<?php

/*
Plugin Name: AIT Claim Listing
Plugin URI: http://ait-themes.club
Description: Adds Claim Listing functionality for ait-item custom post type
Version: 2.16
Author: AitThemes.Club
Author URI: http://ait-themes.club
Text Domain: ait-claim-listing
Domain Path: /languages
License: GPLv2 or later
*/

/* trunk@r225 */

// DEV NOTES >
/*
* item author needs to stay same
* item author is stored in three places > 
** 		$post author id (physical item author -> this is used in the admin display)
**		_ait-item_item-author -> this is used for the metabox storage
**		ait-claim-listing -> this is used for the claim metabox
*** logic behind this
*** admin creates the item -> he is the author	($post -> admin | authorMB -> admin | claimMB -> none)
*** user claims the item -> he is the owner 	($post -> user | authorMB -> admin)
*/

define('AIT_CLAIM_LISTING_ENABLED', true);

AitClaimListing::init();

class AitClaimListing {
	protected static $currentTheme;
	protected static $compatibleThemes;
	protected static $paths;

	public static function init(){
		self::$currentTheme = sanitize_key(get_stylesheet());
		self::$currentTheme = str_replace("-child", "", self::$currentTheme); // child theme hack
		self::$compatibleThemes = array('cityguide', 'directory2', 'eventguide', 'foodguide', 'businessfinder2');

		self::$paths = array(
			'config' => dirname( __FILE__ ).'/config',
			'design' => dirname( __FILE__ ).'/design',
			'templates' => dirname( __FILE__ ).'/templates',
		);

		// WP Plugin functions
		register_activation_hook( __FILE__, array(__CLASS__, 'onActivation') );
		register_deactivation_hook(  __FILE__, array(__CLASS__, 'onDeactivation') );
		add_action('after_switch_theme', array(__CLASS__, 'themeSwitched'));

		add_action('plugins_loaded', array(__CLASS__, 'onLoaded'));
		
		add_action('init', array(__CLASS__, 'onInit'));
		add_action('init', array(__CLASS__, 'addAitItemMetabox'), 12, 0);

		add_action('load-edit.php', array(__CLASS__, 'claimListingActions'));
		add_action('admin_notices', array(__CLASS__, 'claimListingNotices'));

		add_action('save_post_ait-item', array(__CLASS__, 'claimListingPostSaved'), 13, 3 );
		add_action('post_updated', array(__CLASS__, 'claimListingPostUpdated'), 10, 3);

		// Custom columns
		add_filter('manage_users_columns', array(__CLASS__ , 'usersChangeColumns'));
		add_filter('manage_users_custom_column', array(__CLASS__, 'usersCustomColumns'), 10, 3);

		add_filter('manage_ait-item_posts_columns', array(__CLASS__, 'aitItemChangeColumns'), 12, 2);
		add_action('manage_posts_custom_column', array(__CLASS__, 'cptCustomColumns'), 12, 2);

		// Template functions
		add_filter('wplatte-get-template-part', array(__CLASS__, 'getTemplate'), 10, 3);

		// Design functions
		add_action( 'wp_enqueue_scripts', array(__CLASS__, 'enqueueDesign') );
		add_action( 'admin_enqueue_scripts', array(__CLASS__, 'enqueueAdminDesign') );

		// Ajax functions
		add_action( 'wp_ajax_claimItemListing', array(__CLASS__, 'ajaxClaimItemListing'));
		add_action( 'wp_ajax_nopriv_claimItemListing', array(__CLASS__, 'ajaxClaimItemListing'));

		add_action( 'wp_ajax_captchaCheck', array(__CLASS__, 'ajaxCaptchaCheck'));
		add_action( 'wp_ajax_nopriv_captchaCheck', array(__CLASS__, 'ajaxCaptchaCheck'));

		add_action( 'wp_ajax_captchaRenew', array(__CLASS__, 'ajaxCaptchaRenew'));
		add_action( 'wp_ajax_nopriv_captchaRenew', array(__CLASS__, 'ajaxCaptchaRenew'));
	}

	/* WP PLUGIN FUNCTIONS */
	public static function onActivation(){
		AitClaimListing::checkPluginCompatibility();

		// some actions on activation
		AitClaimListing::updateThemeOptions();

		// update database to new format
		AitClaimListing::updateDatabase();

		flush_rewrite_rules();
		if(class_exists('AitCache')){
			AitCache::clean();
		}
	}

	public static function onDeactivation(){
		// some action on deactivation
		flush_rewrite_rules();
		if(class_exists('AitCache')){
			AitCache::clean();
		}
	}

	public static function themeSwitched(){
		AitClaimListing::checkPluginCompatibility();
	}

	public static function checkPluginCompatibility(){
		if ( !in_array(self::$currentTheme, self::$compatibleThemes) ) {
			require_once(ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins(plugin_basename( __FILE__ ));
			//wp_die('Current theme is not compatible with Claim Listing plugin :(', '',  array('back_link'=>true));
			add_action( 'admin_notices', function(){
				echo "<div class='error'><p>" . _x('Current theme is not compatible with Claim Listing plugin!', 'ait-claim-listing') . "</p></div>";
			} );
		}
	}

	public static function onLoaded(){
		load_plugin_textdomain('ait-claim-listing', false,  dirname(plugin_basename(__FILE__ )) . '/languages');

		add_filter('ait-theme-config',array(__CLASS__, 'prepareThemeConfig'));
	}

	public static function onInit(){
		wp_register_script( 'ait-claim-listing-frontend', plugins_url( '/design/js/frontend.js' , __FILE__ ), array('jquery'));
	}
	/* WP PLUGIN FUNCTIONS */

	/* CONFIGURATION FUNCTIONS */
	public static function loadThemeConfig($type = 'raw'){
		$config = include self::$paths['config'].'/theme-options.php';
		return $config[$type];
	}

	public static function prepareThemeConfig($config = array()){
		$plugin = AitClaimListing::loadThemeConfig();

		if(count($config) == 0){
			$theme = self::$currentTheme;
			$config = get_option("_ait_{$theme}_theme_opts", array());
			$plugin = AitClaimListing::loadThemeConfig('defaults');
		}

		return array_merge($config, $plugin);
	}

	public static function updateThemeOptions(){
		// check if the settings already exists
		$theme = self::$currentTheme;
		$themeOptions = get_option("_ait_{$theme}_theme_opts");
		if(!isset($themeOptions['claimListing'])){
			$updatedConfig = AitClaimListing::prepareThemeConfig();
			$theme = self::$currentTheme;
			update_option("_ait_{$theme}_theme_opts", $updatedConfig);
		}
	}

	public static function getPluginThemeOptions(){
		$themeOptions = (object)aitOptions()->getOptionsByType('theme');
		return $themeOptions->claimListing;
	}

	public static function userPackagesSelect(){
		$packages = new ThemePackages();
		$result = array();
		foreach($packages->getEnabled() as $slug => $role){
			$package = $packages->getPackageBySlug($slug);
			$result[$slug] = $package->getName();
		}
		return $result;
	}
	/* CONFIGURATION FUNCTIONS */

	/* CUSTOM ADMIN DISPLAY */
	public static function usersChangeColumns($columns){
		$columns['ait-claim-status'] = __('Claim status', 'ait-claim-listing');
		return $columns;
	}

	public static function usersCustomColumns($value, $column, $id){
		switch($column){
			case 'ait-claim-status':
				$status = get_option('claim_listing_'.$id , false);
				return $status ? __('Claimed', 'ait-claim-listing') : __('Registered', 'ait-claim-listing');
			break;
		}
	}

	public static function aitItemChangeColumns($columns){
		if(current_user_can('manage_options')){
			$columns['ait-claim-status'] = __('Claim status', 'ait-claim-listing');
		}
		return $columns;
	}

	public static function cptCustomColumns($column, $id){
		switch($column){
			case 'ait-claim-status':
				$status = AitClaimListing::getClaimStatus($id);
				switch($status){
					case 'pending':
						echo "<div style='color:orange;'>".$status."</div>";
						echo "<a href='".admin_url('edit.php?post_type=ait-item&claim-action=approve&post-id='.$id)."' class='button'>".__("Approve","ait-claim-listing")."</a>";
						echo "<a href='".admin_url('edit.php?post_type=ait-item&claim-action=decline&post-id='.$id)."' class='button'>".__("Decline","ait-claim-listing")."</a>";
					break;
					case 'approved':
						echo "<div style='color:green;'>".$status."</div>";
						echo "<a href='".admin_url('edit.php?post_type=ait-item&claim-action=decline&post-id='.$id)."' class='button'>".__("Decline","ait-claim-listing")."</a>";
					break;
					default:
						echo "<div>".$status."</div>";
					break;
				}
			break;
		}
	}
	/* CUSTOM ADMIN DISPLAY */

	/* TEMPLATE FUNCTIONS */
	public static function getTemplate($templates, $slug, $name){
		$ok = true;
		foreach(glob(self::$paths['templates'] . '/*.php') as $file){
			$filename = basename($file, '.php');
			if(!self::contains($slug, $filename)){
				$ok = false;
			}else{
				$ok = true;
				break;
			}
		}

		if(!$ok){
			return $templates;
		}

		// create name of file
		// e.g. 'parts/entry-date-format-<NAME>-loop.php'
		// e.g. 'parts/entry-date-format-<NAME>.php'
		if($name){
			//if(!is_singular()) $templates[] = "{$slug}-{$name}-loop.php";
			$templates[] = "{$slug}-{$name}.php";
		}

		// e.g. 'parts/entry-date-format-loop.php'
		// e.g. 'parts/entry-date-format.php'
		//if(!is_singular()) $templates[] = "{$slug}-loop.php";
			$templates[] = "{$slug}.php";

		$locatedInTheme = locate_template($templates, false, false);


		$pluginDir = self::$paths['templates'];

		if(!$locatedInTheme){ // in theme file does not exist, load it from plugin
			$newTemplate = '';
			foreach($templates as $tmpl){
				$tmpl = basename($tmpl);

				if(file_exists("$pluginDir/$tmpl")){
					$newTemplate = "$pluginDir/$tmpl";
				}else{
					continue;
				}
			}
			if(!$newTemplate){
				trigger_error("Template '$tmpl' does not exist in plugin dir nor theme dir");
			}
			return $newTemplate;
		} else {
			return $locatedInTheme; // exist in theme
		}
	}
	/* TEMPLATE FUNCTIONS */

	/* DESIGN FUNCTIONS */
	public static function enqueueDesign(){
		// styles
		$assetPath = file_exists(aitPath('css').'/ait-claim-listing.css') ? aitUrl('css').'/ait-claim-listing.css' : plugins_url( '/design/css/frontend.css' , __FILE__ );
		wp_enqueue_style( 'ait-claim-listing-frontend', $assetPath, false, false, 'screen' );

		// scripts
	}

	public static function enqueueAdminDesign($hook){
		//if($hook == 'post.php' || $hook == 'edit.php'){
			wp_enqueue_style( 'ait-claim-listing-admin', plugins_url( '/design/css/admin.css' , __FILE__ ), false, false, 'screen' );
		//}
	}
	/* DESIGN FUNCTIONS */

	/* METABOX OPTIONS */
	public static function addAitItemMetabox(){
		if(!class_exists('AitToolkit')) return;
		$manager = AitToolkit::getManager('cpts');
		$allCpts = $manager->getAll();

		$params = array(
			'title' => __('Claim Listing', 'ait-claim-listing'),
			'config' => self::$paths['config'].'/ait-item-claim-listing.metabox.php',
		);

		foreach($allCpts as $cpt){
			if($cpt->getId() === 'item'){
				$cpt->addMetabox('claim-listing', $params);
			}
		}
	}
	/* METABOX OPTIONS */

	public static function claimListingActions(){
		if(isset($_GET['post_type']) && $_GET['post_type'] === 'ait-item'){

			if (isset($_GET['claim-action']) && !empty($_GET['post-id'])) {
				$postID = intval($_GET['post-id']);
				// admin can approve all ratings
				if (current_user_can('manage_options')) {
					switch($_GET['claim-action']){
						case 'approve':
							$redirect = admin_url('edit.php?post_type=ait-item&ait-notice=claim-approved');

							$data = get_post_meta($postID, 'ait-claim-listing', true);
							$data['status'] = 'approved';

							update_post_meta($postID, 'ait-claim-listing', $data);
							
							$user = get_user_by('email', $data['owner']);
							
							// update also the _ait-item_item-author data field -> prevent errors
							update_post_meta($postID, '_ait-item_item-author', array('author' => $user->ID));
							
							wp_update_post( array('ID' => $postID, 'post_author' => $user->ID), true );
						break;
						case 'decline':
							$redirect = admin_url('edit.php?post_type=ait-item&ait-notice=claim-declined');

							$data = get_post_meta($postID, 'ait-claim-listing', true);
							$data['status'] = 'unclaimed';
							$data['owner'] = '-';
							$data['date'] = '-';

							update_post_meta($postID, 'ait-claim-listing', $data);

							$user = new WP_User($data['author']);

							// update also the _ait-item_item-author data field -> prevent errors
							update_post_meta($postID, '_ait-item_item-author', array('author' => $user->ID));

							wp_update_post( array('ID' => $postID, 'post_author' => $user->ID) );
						break;
					}
					wp_safe_redirect( $redirect );
					exit();
				}
			}
		}
	}

	public static function claimListingNotices(){
		global $pagenow;
		if($pagenow == 'edit.php'){
			if(!empty($_REQUEST['post_type']) && $_REQUEST['post_type'] == "ait-item"){
				if(!empty($_REQUEST['ait-notice'])){
					switch($_REQUEST['ait-notice']){
						case 'claim-approved':
							echo "<div class='updated'><p>".__( 'Claim listing has been approved', 'ait-claim-listing' )."</p></div>";
						break;
						case 'claim-declined':
							echo "<div class='updated'><p>".__( 'Claim listing has been declined', 'ait-claim-listing' )."</p></div>";
						break;
					}
				}
			}
		}
	}

	public static function claimListingPostSaved($post_id, $post, $updated){
		if ( $parent_id = wp_is_post_revision( $post_id ) ){
			$post_id = $parent_id;
		}

		if(empty($post)){
			$post = get_post($post_id);
		}

		if($post->post_type == 'ait-item'){
			if(!$updated){
				
				$user = new WP_User($post->post_author);

				$packages_enabled = array();
				$themePackages = new ThemePackages();
				$orderedPackages = $themePackages->getOrderedPackages();
				foreach ($orderedPackages as $key => $value) {
					$package = $themePackages->getPackageBySlug($value);
					array_push($packages_enabled, $package->getSlug());
				}

				$user_enabled = false;
				foreach($user->roles as $index => $role){
					if(in_array($role, $packages_enabled)){
						// this user is a package user
						// no need to check further
						$user_enabled = true;
						break;
					}
				}

				// check the claim status / are we just updating post ?
				// enable this functionality only for unclaimed items
				$GLOBALS['ait_saveAuthorMetabox_runned_once'] = true;	// set this to prevent saveAuthorMetabox callback to run
				if($user_enabled){
					// claim the item
					$data = array(
						'status'	=> 'approved',
						'owner'		=> $user->data->user_email,
						'date'		=> time(),
						'author'	=> $post->post_author,
					);

					update_post_meta(intval($post_id), 'ait-claim-listing', $data);

				} else {
					// this is every other user like admin
					// should update the id meta field manually
					$data = array(
						'status'	=> 'unclaimed',
						'owner'		=> '-',
						'date'		=> '-',
						'author'	=> $post->post_author,
					);

					update_post_meta(intval($post_id), 'ait-claim-listing', $data);
				}
			}
		}

	}


	public static function claimListingPostUpdated($post_id, $post_after, $post_before){
		/*if ( $parent_id = wp_is_post_revision( $post_id ) )
				$post_id = $parent_id;*/

		// check if the saving author is administrator
		if($post_after->post_type == 'ait-item' && $post_after->post_author != $post_before->post_author){
			
			$post = $post_after;			// always use the post after because this has new data stored
			$user = new WP_User($post->post_author);

			$packages_enabled = array();
			$themePackages = new ThemePackages();
			
			$orderedPackages = $themePackages->getOrderedPackages();
			error_log(implode(";", $orderedPackages).PHP_EOL, 3, WP_CONTENT_DIR."/save-debug.log");
			foreach ($orderedPackages as $key => $value) {
				$package = $themePackages->getPackageBySlug($value);
				array_push($packages_enabled, $package->getSlug());
			}

			$user_enabled = false;
			foreach($user->roles as $index => $role){
				if(in_array($role, $packages_enabled)){
					// this user is a package user
					// no need to check further
					$user_enabled = true;
					break;
				}
			}

			// check the claim status / are we just updating post ?
			// enable this functionality only for unclaimed items
			$GLOBALS['ait_saveAuthorMetabox_runned_once'] = true;	// set this to prevent saveAuthorMetabox callback to run
			if($user_enabled){
				// claim the item
				$data = array(
					'status'	=> 'approved',
					'owner'		=> $user->data->user_email,
					'date'		=> time(),
					'author'	=> $post_before->post_author,
				);

				update_post_meta(intval($post_id), 'ait-claim-listing', $data);

			} else {
				// this is every other user like admin
				// should update the id meta field manually
				$data = array(
					'status'	=> 'unclaimed',
					'owner'		=> '-',
					'date'		=> '-',
					'author'	=> $post_before->post_author,
				);

				update_post_meta(intval($post_id), 'ait-claim-listing', $data);
			}
		}
	}

	// must be a registered user
	public static function claimItemListing($user_id, $post_id, $notification = true){
		$user = new WP_User(intval($user_id));
		$post = get_post($post_id);

		$data = array(
			'status' => 'pending',
			'owner' => $user->data->user_email,
			'date' => time(),
			'author' => $post->author
		);

		update_post_meta(intval($post_id), 'ait-claim-listing', $data);

		if($notification){
			// notify admin about pending status / mail
			$themeOptions = (object)aitOptions()->getOptionsByType('theme');
			$claimListingOptions = $themeOptions->claimListing;

			$user = new WP_User(intval($user_id));
			$link_user = get_edit_user_link( intval($user_id) );
			$item = get_post(intval($post_id));
			$link_item = get_edit_post_link( intval($post_id) );
			$link_item_approve = "<a href='".admin_url('edit.php?post_type=ait-item&claim-action=approve&post-id='.intval($post_id))."'>".__('Approve claim', 'ait-claim-listing')."</a>";
			$link_item_decline = "<a href='".admin_url('edit.php?post_type=ait-item&claim-action=decline&post-id='.intval($post_id))."'>".__('Decline claim', 'ait-claim-listing')."</a>";

			$user_data = '<a href="'.$link_user.'">'.$user->data->display_name.' ('.$user->data->user_email.')</a>';
			$item_data = '<a href="'.$link_item.'">'.$item->post_title.'</a>';

			$headers = array(
				'Content-Type: text/html; charset=UTF-8',
			);

			$message = AitLangs::getCurrentLocaleText($claimListingOptions['emailMessage']);
			$message = str_replace("{user}", $user_data, $message);
			$message = str_replace("{item}", $item_data, $message);
			$message = str_replace("{actions}", sprintf(__('Actions: %s | %s', 'ait-claim-listing'), $link_item_approve, $link_item_decline), $message);

			wp_mail( get_option( 'admin_email' ), AitLangs::getCurrentLocaleText($claimListingOptions['emailSubject']), $message, $headers );
			// notify admin about pending status / mail
		}
	}

	/* AJAX FUNCTIONS */
	public static function ajaxClaimItemListing(){
		if(isset($_POST)){

			AitClaimListing::claimItemListing($_POST['data']['form_user'], $_POST['data']['form_post']);

			header("HTTP/1.0 200 OK");
			header('Content-Type: application/json');

			echo json_encode(array('result' => true, 'message' => 'Claim successful', 'notification' => 'form-success-claim'));

			exit();
		}
	}

	public static function ajaxCaptchaCheck(){
		if(isset($_POST)){
			if(isset($_POST['data']['form_captcha'])){
				// INCLUDE CAPTCHA
				if(!class_exists("ReallySimpleCaptcha")){
					@include plugin_dir_path( __FILE__ ).'captcha/really-simple-captcha.php';
				}
				$captcha = new ReallySimpleCaptcha();

				if(class_exists("AitTheme")){
					$captcha->tmp_dir = aitPaths()->dir->cache . '/captcha';
				} else {
					$captcha->tmp_dir = plugin_dir_path( __FILE__ ) . 'captcha/cache';
					$captcha->fonts = array(
						plugin_dir_path( __FILE__ ) . 'design/font/gentium/GenBkBasR.ttf',
						plugin_dir_path( __FILE__ ) . 'design/font/gentium/GenBkBasI.ttf',
						plugin_dir_path( __FILE__ ) . 'design/font/gentium/GenBkBasBI.ttf',
						plugin_dir_path( __FILE__ ) . 'design/font/gentium/GenBkBasB.ttf'
					);
				}
				// INCLUDE CAPTCHA
				header("HTTP/1.0 200 OK");
				header('Content-Type: application/json');

				if($captcha->check('ait-claim-listing-captcha-'.$_POST['data']['rand'], $_POST['data']['form_captcha'])){
					echo json_encode(array('result' => true, 'message' => 'Captcha OK', 'notification' => 'form-okey-captcha'));
				} else {
					echo json_encode(array('result' => false, 'message' => 'Wrong captcha', 'notification' => 'form-error-captcha'));
				}

				exit();
			}
		}
	}
	public static function ajaxCaptchaRenew(){
		$rand = rand();
		if(!class_exists("ReallySimpleCaptcha")){
			@include plugin_dir_path( __FILE__ ).'captcha/really-simple-captcha.php';
		}
		$captcha = new ReallySimpleCaptcha();

		$imgUrl = "";
		if(class_exists("AitTheme")){
			$captcha->tmp_dir = aitPaths()->dir->cache . '/captcha';
			$cacheUrl = aitPaths()->url->cache . '/captcha';
		} else {
			$captcha->tmp_dir = plugin_dir_path( __FILE__ ) . 'captcha/cache';
			$captcha->fonts = array(
				plugin_dir_path( __FILE__ ) . 'design/font/gentium/GenBkBasR.ttf',
				plugin_dir_path( __FILE__ ) . 'design/font/gentium/GenBkBasI.ttf',
				plugin_dir_path( __FILE__ ) . 'design/font/gentium/GenBkBasBI.ttf',
				plugin_dir_path( __FILE__ ) . 'design/font/gentium/GenBkBasB.ttf'
			);
			$cacheUrl = plugin_dir_url( __FILE__ ) . 'captcha/cache';
		}
		$img = $captcha->generate_image('ait-claim-listing-captcha-'.$rand, $captcha->generate_random_word());
		$imgUrl = $cacheUrl."/".$img;

		echo json_encode(array('rand' => $rand));
		exit();
	}
	/* AJAX FUNCTIONS */

	/* HELPER FUNCTIONS */
	public static function contains($haystack, $needle){
		return strpos($haystack, $needle) !== FALSE;
	}

	public static function getClaimStatus($post_id = null){
		// claimed / pending / unclaimed
		if(empty($post_id)){
			global $post;
			$post_id = $post->ID;
		}
		$result = __('unclaimed', 'ait-claim-listing');
		$meta = get_post_meta($post_id, 'ait-claim-listing', true);
		if(!empty($meta)){
			$result = $meta['status'];
		}

		return $result;
	}

	public static function getClaimOwner($post_id = null){
		if(empty($post_id)){
			global $post;
			$post_id = $post->ID;
		}
		$result = '-';
		$meta = get_post_meta($post_id, 'ait-claim-listing', true);
		if(!empty($meta)){
			$result = $meta['owner'];
		}

		if($result != "-"){
			$user = get_user_by('email', $result);
			if($user){
				// user is registered within wordpress
				$result = '<a href="'.get_edit_user_link( $user->ID ).'">'.$user->data->display_name.' ('.$user->data->user_email.')</a>';
			} else {
				$result = __("Not registered", "ait-claim-listing").' ('.$result.')';
			}
 		}

		return $result;
	}

	public static function getClaimDate($post_id = null){
		if(empty($post_id)){
			global $post;
			$post_id = $post->ID;
		}
		$result = '-';
		$meta = get_post_meta($post_id, 'ait-claim-listing', true);
		if(!empty($meta)){
			$result = $meta['date'];
		}

		if($result != "-"){
			$result = date(get_option('date_format'), $result);
		}

		return $result;
	}

	public static function getUserPackageSlug($user = null){
		if(empty($user)){
			$user = wp_get_current_user();
		}
		$result = null;
		foreach($user->roles as $index => $role){
			if (strpos($role,'cityguide_') !== false) {
				$result = $role;
			}
		}
		return $result;
	}

	public static function canUserClaim($user, $package){
		$result = true;

		if($package != null){
			$package_options = $package->getOptions();

			if(intval($package_options['maxItems']) > 0){
				$query = new WP_Query(array('post_type' => "ait-item", 'author' => $user->ID));
				if(count($query->posts) >= intval($package_options['maxItems'])){
					$result = false;
				}
			} else {
				$result = false;
			}
		}

		return $result;
	}
	/* HELPER FUNCTIONS */

	/* UPDATE FUNCTIONS */
	// update data from old format to new
	public static function updateDatabase(){
		$query = new WP_Query(array(
			'post_type' => 'ait-item',
			'nopaging' => true
		));

		foreach ($query->posts as $post) {
			$author = new WP_User(intval($post->post_author));

			if($author->ID != 0){
				// user exists

				$claim = get_option('claim_listing_'.intval($post->post_author), false);
				if($claim !== false){
					// we have old claim data

					$data = array(
						'status'	=> 'approved',
						'owner'		=> $author->data->user_email,
						'date'		=> time(),
						'author'	=> 1,
					);

				} else {
					// we doesnt have old claim data

					$isAdmin = false;
					foreach($author->roles as $role){
						if($role === 'administrator'){
							$isAdmin = true;
							break;
						}
					}

					if($isAdmin){
						// post author is admin

						$data = array(
							'status'	=> 'unclaimed',
							'owner'		=> '-',
							'date'		=> '-',
							'author'	=> $post->post_author,
						);
					} else {
						// post author is not admin

						$data = array(
							'status'	=> 'approved',
							'owner'		=> $author->data->user_email,
							'date'		=> time(),	// should be post created time, but instead is is the time when the plugin was activated
							'author'	=> $post->post_author,
						);
					}

				}
			} else {
				// user doesnt exist

				$data = array(
					'status'	=> 'unclaimed',
					'owner'		=> '-',
					'date'		=> '-',
					'author'	=> 1,
				);
			}

			/* Old Code
			if(!is_array(get_post_meta($post->ID, 'ait-claim-listing', true))){
				// we dont have this kind of meta in database
				update_post_meta($post->ID, 'ait-claim-listing', $data);
			}
			 Old Code */

			// for version 2.11 we must update all metadata
			// there is wrong metadata set for user which is not admin
			/* Should be > status: approved | owner: user email | date: post date | author: post id */
			/* Currenty > status: unclaimed | owner: - | date: - | author: 1 */
			update_post_meta($post->ID, 'ait-claim-listing', $data);

		}
	}
	/* UPDATE FUNCTIONS */
}