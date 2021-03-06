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
define('DB_NAME', 'matexcel');

/** MySQL database username */
//define('DB_USER', 'matexcel');
define('DB_USER', 'root');

/** MySQL database password */
//define('DB_PASSWORD', 'Y6HKd8BrWVpkEyFK');
define('DB_PASSWORD', 'root');

/** MySQL hostname */
//define('DB_HOST', 'cddbmysql.c8qakfd9b1ln.us-west-1.rds.amazonaws.com');
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         '*^&CVD$xn8@eF+B$,$gXs7w,47aB4qd41%wZpFfu(gZ.9za#}=;]Q&/ui! O<Fp/');
define('SECURE_AUTH_KEY',  'Ahsbz#2WS8_F+,2;ndt}G-C5.p%q}/JAqVGg8NHc}:[k8e7)FZ]Qe:Slu]mHJuOw');
define('LOGGED_IN_KEY',    'KT%SsffgNA%+yB!.+Mz!*?:=H0`{hq}r7SZ{%{ceU{o^?{=e;a,k>W^[9sH!:to6');
define('NONCE_KEY',        '&Xe8c(9F?240IYMbFL PbeHV(oF+-^?nS9U|z_tII^{rcxd1H;q<;c+bNs^8YPQt');
define('AUTH_SALT',        '+r?bOhL.r t 3s,L%;>s&RTZDjWb4jVr2|#d+;/=^IsL+95*!3=g-@U=hc28jne^');
define('SECURE_AUTH_SALT', 'H]!YPT?-K[kO`bd})OMB5N:L~F +}!#;Ogw:5<O9Gv&rS3$y,US)~1 aJ2PVLnnT');
define('LOGGED_IN_SALT',   'qdFmTvT7pIHcHDa!!&rT:}v6L.8rw=SD< `_1VcMA8q%Jz&^[jG*XMvo4sG5o~pk');
define('NONCE_SALT',       'vBQ^j%k,Iy f1=!Jc!Aue;z==i#lVvZ:MZNb3YsiJRsO*<&#g.u]ZAb3V|Kl8NL[');

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

$host = $_SERVER['HTTP_HOST'];
$https = $_SERVER['HTTPS'];
if($https=='on'){
	define('WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'].'/');
	define('WP_HOME', 'https://' . $_SERVER['HTTP_HOST'].'/');
}else{
	define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'].'/');
	define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'].'/');
}


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

define ('WP_CONTENT_DIRNEW', 'public');   //zq-public ????????????
define ('WP_CONTENT_DIR', ABSPATH . WP_CONTENT_DIRNEW);
define('WP_CONTENT_URL', WP_SITEURL . WP_CONTENT_DIRNEW);

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
