<?php
/**
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define( 'DB_NAME', 'tatutradv3-migrated' );

/** Tu nombre de usuario de MySQL */
define( 'DB_USER', 'root' );

/** Tu contraseña de MySQL */
define( 'DB_PASSWORD', 'root' );

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define( 'DB_HOST', 'localhost' );

/** Codificación de caracteres para la base de datos. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', '$h%qCleuuo*opGq[K+-OchhwG3u*c4cxz+0t.0(4s%WR0/(cL8K|YBlV)|m]A/C,' );
define( 'SECURE_AUTH_KEY', 'X9?8p-tcGVO:.v]f%s#%OflGZ-<)I)Sip_}2f=J3/LNHH $2el]UCTh@B=6Ag*3?' );
define( 'LOGGED_IN_KEY', 'v_Y-tjni V[FEKt{;Cd^pO+;qqBiDi$ri*NI-j0In&(b&MPU@HJ6)}7&)TN(TH~9' );
define( 'NONCE_KEY', 'jQ35V+E5o!Seq5OQYHq-GIh@Z6E3fkxsV63w@=I5_#K-jMmkW8t~ji+];&#I$})!' );
define( 'AUTH_SALT', '5I?eo?bQU9m/QQriYB=BGKt6aDo(|2{ZFOa_7RfW`+LMM&/UA@JvU&YfT]gw:`rB' );
define( 'SECURE_AUTH_SALT', 'ZdMYqPkI>7}aK`QR${?08|pk ,/blNz.z]&]](YF<o0Jg|S6!:cxd?3!4~}j_Ggd' );
define( 'LOGGED_IN_SALT', ':YdhyI_Q%j@rAsbxdxyL*DDF_1;hG,3H$![Sc06Sv>(7s@`3-1uhqW9mbs|6O**`' );
define( 'NONCE_SALT', '}W9|6BRH&zoBDT!RJ.[rH?Jm@6bAS[_kdOhFJbD_*HdjUdF&bRc}%jZ9`{Azmak1' );

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix = 'wp_tatu3_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

