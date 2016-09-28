<?php
/**
 * Plugin Name: AIT Stripe Payments
 * Version: 1.1
 * Description: Adds Stripe gateway to City Guide Theme
 *
 * Author: AitThemes.Club
 * Author URI: https://ait-themes.club
 * License: GPLv2 or later
 * Text Domain: ait-stripe
 * Domain Path: /languages
 */

/* trunk@r22 */

defined('ABSPATH') or die();
define('AIT_STRIPE_ENABLED', true);
include_once(__DIR__.'/load.php');

add_action('after_setup_theme', function() {
	try {
		AitStripe::getInstance();
	} catch (Exception $e) {
		AitStripe::log($e);
	}
});

register_activation_hook(__FILE__, function() {
	AitCache::clean();
});

add_action('plugins_loaded', function() {
	load_plugin_textdomain('ait-stripe', false, dirname(plugin_basename( __FILE__ )) . '/languages');
}, 11);