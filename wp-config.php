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
define( 'DB_NAME', 'coalitiontest' );

/** Database username */
define( 'DB_USER', 'wpuser' );

/** Database password */
define( 'DB_PASSWORD', 'wppass' );

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
define( 'AUTH_KEY',          'y5tp$/cNpuf#3[aF3!%j^qiRv>X1aN++W9;<3Vzr}eo1c)N)2G&ndZ.hCQOHS?wc' );
define( 'SECURE_AUTH_KEY',   'Y~Sqg-Tg=e}B`x#=5.2d=x9vw4SJYLMvlpQbhePvEbm9`WE1_^f#}ClZ9r[DHw-d' );
define( 'LOGGED_IN_KEY',     'ez4G R>6o$><#;joq@C[vobOAu)L0$}+ywV`rZr,OW8M>shGLnXYy>jA+aQzGxI:' );
define( 'NONCE_KEY',         '=ZraNyecy;BGlstDzMuhSXSfK(m~c$8C|Tt>]IwWOYce&0*<Ks|H+]nJic^*6+:s' );
define( 'AUTH_SALT',         'r1e&?p q%`K.CK>M>AP9g)=, 9m|@(*_nHFIXJi*EgggS|C4MV6w5.x_CG~~qA&!' );
define( 'SECURE_AUTH_SALT',  '|]=oY900;jGUNR9pcxAhn,]r[[LD[,lA!pU_nas.JC<){LjKgip,D*Y7!k[lo<K9' );
define( 'LOGGED_IN_SALT',    '%C+#ydbgEo{QRXw0SSt|}t+UR22V?/aTozxn$Knb0PJ7C?RsVZLXdaY6ResNgJ7e' );
define( 'NONCE_SALT',        'G/qi1G*Rh7 h0 _Pq[{5ZSt^=3~]n`WQ=5Oxf1~I^>wu*8ERC/h}o?lR;eKvlCRS' );
define( 'WP_CACHE_KEY_SALT', 'QTt}&QShQacDn5CII,g;d nEM?g,5OY&tLrsF/t&<q*B1~7oww`/PbfhaNr;gZs8' );


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
	define( 'WP_DEBUG', false );
}

define( 'WP_MEMORY_LIMIT', '256M' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
