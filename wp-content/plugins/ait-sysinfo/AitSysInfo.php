<?php


class AitSysInfo
{
	const VERSION_KEY = '_ait_sysinfo_version';
	const SLUG = 'ait-sysinfo';

	public $pluginDir;
	public $pluginUrl;

	private static $instance;



	protected function __construct()
	{
		$this->pluginDir = dirname(__FILE__);
		$this->pluginUrl = plugins_url('', __FILE__);
	}



	public function run()
	{
		register_activation_hook(__FILE__, array($this, 'onActivation'));
		register_deactivation_hook(__FILE__, array($this, 'onDeactivation'));

		// Any other hooks we need
		add_action('plugins_loaded', array($this, 'loadTextdomain'));
		add_action('admin_menu', array($this, 'onAdminMenu'), 12);
		add_filter('plugin_action_links', array($this, 'addPluginActionLinks'), 10, 2);
	}



	protected function activate()
	{
		update_option(self::VERSION_KEY, AIT_SYSINFO_VERSION);
	}



	protected function deactivate()
	{
		delete_option(self::VERSION_KEY);
	}



	public function onActivation($networkWide)
	{
		$this->doForEachSite('deactivate', $networkWide);
	}



	public function onDeactivation($networkWide)
	{
		$this->doForEachSite('deactivate', $networkWide);
	}



	protected function doForEachSite($action, $networkWide)
	{
		if($networkWide and is_multisite()){
			global $wpdb;

			foreach($wpdb->get_col("SELECT blog_id FROM $wpdb->blogs") as $blogId) {
				switch_to_blog($blogId);
				$this->{$action}();
			}
			restore_current_blog();
		}else{
			$this->{$action}();
		}
	}



	public function loadTextdomain()
	{
		load_plugin_textdomain('ait-sysinfo', false, basename($this->pluginDir) . '/languages/');
	}



	public function onAdminMenu()
	{
		$adminPages = array();

        if(!defined('AIT_SKELETON_VERSION')){
			$pageHookname = add_menu_page(
				'AIT SysInfo - System Information',
				'AIT SysInfo',
				'manage_options',
				self::SLUG,
				array($this, 'addAdminPage'),
				'dashicons-clipboard'
			);
		}else{
            $pageHookname = add_submenu_page(
                'ait-theme-options',
                'AIT SysInfo - System Information',
                'AIT SysInfo',
                'manage_options',
				self::SLUG,
				array($this, 'addAdminPage')
            );
        }

		add_action("admin_print_styles-{$pageHookname}", array($this, 'printAdminCss'));
		add_action("admin_head-{$pageHookname}", array($this, 'printAdminJs'));
	}



	public function addAdminPage()
	{
		?>

		<div class="wrap">
			<div id="ait-sysinfo-page">
				<h1>AIT SysInfo <small>v<?php echo AIT_SYSINFO_VERSION ?></small> - <?php _e('System Information', 'ait-sysinfo') ?></h1>
				<?php AitSysInfoReporter::getInstance($this)->generateReport(); ?>
			</div>
		</div>

		<?php
	}



	public function printAdminCss()
	{
		?>
		<style>
			#ait-sysinfo-page {
				margin: 0px 20px 20px 0px;
			}
			#ait-sysinfo-page .clear {
				clear: both;
			}
			#ait-sysinfo-page .wrap {
				margin-right: 0px;
			}
			#ait-sysinfo-page h2.title {
				float: left;
				margin-bottom: 10px;
			}

			#ait-sysinfo-page textarea {
				font-family: Consolas, 'Courier New', Courier, monospace;
				font-size: 14px;
				width: 100%;
				height: 600px;
				background-color: #f9f9f9;
				margin-top: 15px;
			}
		</style>
		<?php
	}



	public function printAdminJs()
	{
		?>
		<script>
			jQuery(function($){
				var $btn = $('#ait-sysinfo-copy');
				var $msg = $('<span></span>').css({'color': 'green', 'padding-left': '10px', 'line-height': '26px'}).hide().text('<?php _e('Copied!', 'ait-sysinfo') ?>');
				$btn.after($msg);

				$btn.on('click', function(event){
					var copyTextarea = document.querySelector('#ait-sysinfo-report');
					copyTextarea.select();
					try{
						var successful = document.execCommand('copy');
						if(successful){
							$msg.show().delay(1000).fadeOut(800);
						}
					}catch(err){
						$msg.text('<?php _e('Press Ctrl+C to copy', 'ait-sysinfo') ?>'); // Safari
						$msg.show().delay(1500).fadeOut(800);
					}
				});
			});
		</script>
		<?php
	}



	public function addPluginActionLinks($links, $file)
	{
		static $_thisPlugin;

		if(!$_thisPlugin){
			$_thisPlugin = plugin_basename(__FILE__);
		}

		if($file == $_thisPlugin){
			array_unshift($links, '<a href="' . admin_url('tools.php?page=' . self::SLUG) . '">' . __('View', 'ait-sysinfo') . '</a>');
		}

		return $links;
	}



	public static function getInstance()
	{
		if(!self::$instance){
			self::$instance = new self;
		}

		return self::$instance;
	}

}
