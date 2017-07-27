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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root123@#');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
 define('AUTH_KEY',         'jEZ-Z?S8I%-&e@F.xS.mes+JNHq-g7cHJ0$~4Nk^Q;IMi*L.a6c5+jCHiA>@}ljy');
 define('SECURE_AUTH_KEY',  '5fe}!zXUH-H-Mca@g1%#TQf>eL|7@01M)ikn+`a84`C(XU~hUgDy/=Y]MtB8[Gx/');
 define('LOGGED_IN_KEY',    'L^*WvE;dT?-B^PZm:uS!yW-X<2b<uA,RFR+K9^1B?KiS$:7B8&M=Y(+exYIp&x.*');
 define('NONCE_KEY',        'oIs50*^?&;x@G1BL^) W[Ui-)VB{5=@%;LJX/6`B FGc?#oYE[,H6%Al9Oy2c;Vt');
 define('AUTH_SALT',        '}b-{x7B,8rE^K+egXdiB89/Ba6k )-,<QHe|4NRkvepst|_Si3Cd.<V0CZSs<W]s');
 define('SECURE_AUTH_SALT', '!hZzWAgG&v=2!a%)qA7i0sw8hzT$=g+XfHn|<Zfo-!BX%kKc@TnOO&I>@C`FIy%6');
 define('LOGGED_IN_SALT',   'oy*H{MxKO^^G@q)!j|+oS7bz^-*}IxaVBgtUGU$-YC8}ty.eLElLLY&fb[)|xs@N');
 define('NONCE_SALT',       'H,mQD|_b:$Hk*xLDp0])LB^^bGy&>^k.!D:|C+M|G^gGaFF}U~&si,|&R@2P+/p=');

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
