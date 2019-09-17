<?php
define('WP_AUTO_UPDATE_CORE', false);// Este parámetro fue definido por el paquete de herramientas de WordPress para impedir la actualización automática de WordPress. No lo modifique para así evitar conflictos con la prestación de actualización automática del paquete de herramientas de WordPress.
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

define('DB_NAME', 'wp1_tatutradne');
define('DB_USER', 'wp1_tatutradne');
define('DB_PASSWORD', '2016ta');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
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
define('AUTH_KEY', 'et$Rhiz_a<wNBB|^UxT~_,TS_@0Bh0Z+dB/P=XsccR0xFi$QY$pu8a1)u7J,,L7u');
define('SECURE_AUTH_KEY', 'y&~PU+H2R,kRz*?8M2?fi&(_Mab73]LsW-Kv6m=@Fxcm6UL%Lr_qPaL-h@g}Fn,-');
define('LOGGED_IN_KEY', '~Wx]JX;Z#60v3;]OQ;A. &R0GWNB[gO0216r9zvQg%y D.#$-{8iNSt>nmp;&=b^');
define('NONCE_KEY', 'ZaE><75Gl.Q{yy:S;y%]K]~+OS.MR:k5,Ec]$OqOC8{1(]>8lE8^Z[=i`G?o|Fs6');
define('AUTH_SALT', 'w5==Sw|kQ5NHuV<;L9D]|w+2sgLfHc~2om=iLxgt[7Xl`S OA.e77[&AE~*cB&r]');
define('SECURE_AUTH_SALT', '1@&,,9I:3N,kh!=f</JFuF1]@,;C)>G-3pmm*]^+Fq!;HBD6|>_C>,GBLM6+4><<');
define('LOGGED_IN_SALT', '^{w}i.[r.PM$Sw]muz6_pV8KnR5tx=dtRq-A?pB_Y1;6iTY/w%O35EI<EtgN7#vA');
define('NONCE_SALT', '.}DNYU}&lu&<V<.B9Bbb^w0ntS&WJ K{p,o6WYcrwO6akT:Y1VT?(4n:/u>*HD y');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


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

