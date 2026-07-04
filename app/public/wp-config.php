<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'to|>K$@x7C9|?w.I4=~)vo]Eo@4XKK.)O- %LT;WC]:O%0Odo&:1>:XRbbe@r&lk' );
define( 'SECURE_AUTH_KEY',   '?I1ty<E;s$Y#a1j2CSH.wCvSL(Veei3O_gXd8)ha8-+N.DBwiDvYW|q$y)E_x:Ew' );
define( 'LOGGED_IN_KEY',     '}&,A<z}`+5TM@W)5~M+<RZfc.wt.*~wC7jNem?W9!(.-lIkVieO&My.4@pgdah|Y' );
define( 'NONCE_KEY',         '?OQT?by}d_eB<VR;.fBu_;7Olj/:9E0GF!ds(D|yG,t+htUa$?(ZQa%5qkouAZG?' );
define( 'AUTH_SALT',         '8y-Vv9s~Eu#=m*~xs4A@;~**,c>-hjtyf#)?E8r%&q;N)T])hj6,H58dxPJUG<We' );
define( 'SECURE_AUTH_SALT',  '^+LX7B3MEqJN5P%C-bP&n^3/Wf 2+8ga@[_)%I>q)n)4.rmlGr^BfOkq2hNNH?d|' );
define( 'LOGGED_IN_SALT',    'RYc_7~|0W(M*p7ZY<K}5#ul`P+^t])jr<;3<%|d^W~5ewl$fg^F{aW!KsK5*Y]^l' );
define( 'NONCE_SALT',        't-PH/4%Csdp66T&vv/H~ntd.U#`.e/eYI;l:aX0IziQr}badYns?@vdZvi1Sc:mL' );
define( 'WP_CACHE_KEY_SALT', ',S~j,K@DKyXI.T*@ ]Z8>N!4*7(:`=YYK _J`RcH7~lb:*/+v-K%8&(vJY_o:%KT' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
