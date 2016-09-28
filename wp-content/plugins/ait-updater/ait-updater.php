<?php

/**
 * Plugin Name: AIT Updater
 * Version: 3.4.1
 * Description: Updater for themes and plugins from AitThemes.Club
 * Plugin URI: https://www.ait-themes.club/wordpress-plugins/ait-updater/
 *
 * Author: AitThemes.Club
 * Author URI: https://ait-themes.club
 * License: GPLv2 or later
 * Network: true
 * Text Domain: ait-updater
 * Domain Path: /languages/
 */


/* stable@r333 */


define('AIT_UPDATER_ENABLED', true);


if(is_admin()){
	require_once dirname(__FILE__) . '/src/load.php';
	Ait\Updater::getInstance()->run(__FILE__);
}
