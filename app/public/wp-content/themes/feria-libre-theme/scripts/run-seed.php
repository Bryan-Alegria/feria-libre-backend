<?php
/**
 * Wrapper para ejecutar seed-data.php con configuración de base de datos correcta
 */

// Definir constantes de base de datos antes de cargar WordPress
define( 'DB_NAME', 'local' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', '127.0.0.1:10005' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// Cargar WordPress
require_once dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/wp-load.php';

// Cargar y ejecutar el script de seed data
require_once dirname( __FILE__ ) . '/seed-data.php';
