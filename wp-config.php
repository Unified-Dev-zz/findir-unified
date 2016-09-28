<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'zaerodes_wp537');

/** MySQL database username */
define('DB_USER', 'zaerodes_wp537');

/** MySQL database password */
define('DB_PASSWORD', '4pS(eS4[72');


/** MySQL hostname */
define('DB_HOST', '69.175.35.82');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'tjhni9e6s7ho3hsncbdivmsjkwf1yyas6jljelgpceulo1ayzyzrkb81hu7x8xmc');
define('SECURE_AUTH_KEY',  '4pjjlgm4ft37uebhgb0vup2qa9nqw5xa09stmemsb4jnxqo9mixfdus5lgidoyol');
define('LOGGED_IN_KEY',    'd62wcvoqptsblxsajjyjhawzmdbmqtts1l2ezn7lpbjgsgcvrowfpt4irraboz5a');
define('NONCE_KEY',        'wzxj3xnqifzprlhg3dttm350lp1xhnfci3blu52ynuen5uu0y7hsgrwdwh6xr71u');
define('AUTH_SALT',        '3zy8abctwsgqaqgumyoedujxkz9u2fvgrquaytsesi2teek10l8tsf496nrtfuj8');
define('SECURE_AUTH_SALT', 'krfhx6qciwx6mxjioaokfb95tync8trfeaatisosyeseqmzl0mw1pt9a1hpo7tj3');
define('LOGGED_IN_SALT',   'p3xc2y4lipawamnkrsjfjolwak0uzo9ws5uwpjogytf45pfodqwco71ieui4uep3');
define('NONCE_SALT',       'fv0vplsuodw21bywztgqvqz6gtvalhna9cdkllm66cnaaa647dsbhihwv1j69qrn');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wprb_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
