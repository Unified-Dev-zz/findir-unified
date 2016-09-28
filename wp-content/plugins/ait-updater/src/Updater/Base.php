<?php

namespace Ait\Updater;

use Ait\Updater\Admin\SettingsPage;


class Base
{

	/**
	 * @var Ait\Updater
	 */
	protected $updater;

	/**
	 * @var array
	 */
	protected $errors = array();

	/**
	 * @var self
	 */
	private static $instance;



	public function run($updater)
	{
		$this->updater = $updater;
		add_action('plugins_loaded', array($this, 'onPluginsLoadedCallback'));
		add_action('admin_head', array($this, 'onAdminHeadCallback'));
	}



	public static function getInstance()
	{
		$class = get_called_class();
		if(!isset(self::$instance[$class])){
			self::$instance[$class] = new static;
		}

		return self::$instance[$class];
	}



	public function onAdminHeadCallback()
	{
		$hook = is_multisite() ? 'network_admin_notices' : 'admin_notices';
		add_action($hook, array($this, 'onAdminNoticesCallback'));
	}



	public function onAdminNoticesCallback()
	{
		$this->updater->displayAdminNotices($this->errors);
	}



	protected function createTempFilePlaceholder($codename)
	{
		$tmpfname = wp_tempnam($codename);

		if(!$tmpfname){
			return new \WP_Error('http_no_file', __('Could not create temporary file.', 'ait-updater'));
		}

		return $tmpfname;
	}



	public function addError($errorMsg)
	{
		$this->errors[] = $errorMsg;
	}



	public function getErrors()
	{
		return $this->errors;
	}



	public function hasErrors()
	{
		return !empty($this->errors);
	}
}