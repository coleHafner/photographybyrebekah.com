<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pbr');

/** MySQL database username */
define('DB_USER', 'pbr_user');

/** MySQL database password */
define('DB_PASSWORD', 'passwd1000!');

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
define('AUTH_KEY',         '|J&Nlk ^HeZpn=]EP!F@WH8=KTtm%V;% g)8Y;U+>dua$yk>.Qzk(WY9b>m=ofo)');
define('SECURE_AUTH_KEY',  ']=_*4S@dB2Xe#~J|,+i4RF,kF94dX(&|]I{N9r8~&9d$d8atW+V5=Xcg^q1Qpp>x');
define('LOGGED_IN_KEY',    '9(GTZAS4bJMNeweR.Xh[S9BeCku Q6eGo^*(7@L+KB{VfF/iw;`lk2RL{%Ji,eF+');
define('NONCE_KEY',        '0YTAGhIg(TORhhKNTZf[jzSI&,oEN7sl*@_`AfGT8W TeV2tQwYb&i;5x(2Pr0G9');
define('AUTH_SALT',        '&a[[Na,Gd;JAxr:25go@V;AB4Aa^~7 H>#Q{VKM_f:!S5=7>;m<RN]t>(uVq9kz_');
define('SECURE_AUTH_SALT', 'eux7{U#n(%)bh<%_?A :>QCse)c%c4vl3eW6)Ee/8?,x.??0F8(_aHib<$%pM${-');
define('LOGGED_IN_SALT',   '0F? A-SNJ1J0W?V5/Q`{6Z>yR h&j=4R(G]c=f|epi mzU/%r/Ehj3(`%@`f#Yjc');
define('NONCE_SALT',       '5Dqin8Za27B~`c:l9aY.wIfh.{Q/:;3At?%62^wO+Wt8Lrqfs8WZxFbboO%uT,>I');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
