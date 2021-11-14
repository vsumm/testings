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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vtest' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         ')t4o60=/Dsd[w;&Fx.9${>x)94_qzYL7]?k4$#1Rc]xIZ8Fp^odQAV=Cn<URHoJM' );
define( 'SECURE_AUTH_KEY',  'WG(fZ%=/vGY_A?(qdBcY!@<d3zt<*`^bHOi03?!1IGz{?^U$[;(z,v8|T@]igdxO' );
define( 'LOGGED_IN_KEY',    'wU@SZko]M;Wr!g@~4f:`n2S8H{zEEn:s;DsJD~r^Mi|rE_/zc9Gl/7j; xt)4UmP' );
define( 'NONCE_KEY',        '~WCAz=2A6pq|H7N%FC6ZLdlBKyvGjz^xM+O0z-cC~ utnVy>!:wgPO/ >(?-8.@e' );
define( 'AUTH_SALT',        '-XUdY1@`!F`j{`1*00;e.S7y2G$(k6u9w^s>&^S*:0Om[Q(>|uMnpN1@mw|n!q{g' );
define( 'SECURE_AUTH_SALT', 'dM#[=?[i%A`u(xaLR;T:t:6=a#%!D0[mO?7yrR=JWgPLWA,{=lGGo&|RKD8akmf>' );
define( 'LOGGED_IN_SALT',   'V`wc*@5&70sf<3G(A{Dmd/3KJyD`0V:p-?8.Q_C#B&,bpCxZTw=6>)7*h&dW4n}E' );
define( 'NONCE_SALT',       '}J6kzDA$]~,ydK*K_3/QCtV]Q01R{9V?`F ux,e,ypSO6?CD<{p/HD],Ha(K55q?' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
