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
define('DB_NAME', 'abscbn_db');

/** MySQL database username */
define('DB_USER', 'abscbn_db');

/** MySQL database password */
define('DB_PASSWORD', 'hitman052529');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '4xb9ZE{UC/Vz_``&n}tFWeTq+n^M?V5S/6QqEh-M18[TgK#@w_Y9~;TRYaMJN0+k');
define('SECURE_AUTH_KEY',  'uFYmaT6?7mjw|2PsQLf:4Rfebl3q*!a>G]@|kpco-uL`ly+R{I&0xdWA|3K&IGlJ');
define('LOGGED_IN_KEY',    '-U[B{#JqBJat!9!t+CR*!#):B^lT|5^Ol5]ltcPIU0Bc;c@L/R^+;:A6RzpE+AuX');
define('NONCE_KEY',        'Ih`Im:.V:-C`d!``7tB1|.KI=jpKzI^qx(h^aLrt!lH&T8g^08^!}4{O`df/UBEm');
define('AUTH_SALT',        '=l}q[F5X)+QU6oh)3iSm+ka?hc$2/7UD,!+X`U<#ZM2W7QH%m~bVh!! q)q2UsvT');
define('SECURE_AUTH_SALT', '#x9WLPyG+3?L|^HK5;67]+YRetdf2*@?@&#bIZ[|<+vMDaOctKev*m$)N6=1G|k.');
define('LOGGED_IN_SALT',   'P41CSgKOQ;D]rwFX*ud&s_45]3{j`!~Y44SjV|2T cZb[woc<y%W?R4Ukn=#COPe');
define('NONCE_SALT',       'ea;w}l+Dt;?-y()uAa+>]#=ek 01|i3Y,0y-3[/MwwmXwO>)5%mbVTJ@*Vw+c%Gz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
