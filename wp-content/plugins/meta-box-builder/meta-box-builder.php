<?php
/**
 * Plugin Name: Meta Box Builder
 * Plugin URI: https://www.metabox.io/plugins/meta-box-builder
 * Description: With our "Drag and Drop" function, creating Meta Boxes and Custom Fields has never been easier.
 * Version: 2.0.7
 * Author: Tan Nguyen <tan@binaty.org>
 * Author URI: http://www.binaty.org
 * License: GPL2+
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// ----------------------------------------------------------
// Define plugin URL for loading static files or doing AJAX
// ------------------------------------------------------------
if ( ! defined( 'MBB_URL' ) )
	define( 'MBB_URL', plugin_dir_url( __FILE__ ) );

define( 'MBB_INC_URL', trailingslashit( MBB_URL . 'inc' ) );
define( 'MBB_JS_URL', trailingslashit( MBB_URL . 'assets/js' ) );
define( 'MBB_CSS_URL', trailingslashit( MBB_URL . 'assets/css' ) );

// ------------------------------------------------------------
// Plugin paths, for including files
// ------------------------------------------------------------
if ( ! defined( 'MBB_DIR' ) )
	define( 'MBB_DIR', plugin_dir_path( __FILE__ ) );

define( 'MBB_INC_DIR', trailingslashit( MBB_DIR . 'inc' ) );
define( 'MBB_FIELDS_DIR', trailingslashit( MBB_INC_DIR . 'fields' ) );

require_once MBB_INC_DIR . '/helpers.php';
require_once MBB_INC_DIR . '/class-meta-box-attribute.php';
require_once MBB_INC_DIR . '/fields/field.php';
require_once MBB_INC_DIR . '/class-meta-box-show-hide-template.php';
require_once MBB_INC_DIR . '/class-meta-box-include-exclude-template.php';
require_once MBB_INC_DIR . '/class-meta-box-processor.php';
require_once MBB_INC_DIR . '/class-meta-box-import.php';
require_once MBB_INC_DIR . '/class-meta-box-builder.php';

new Meta_Box_Builder;
