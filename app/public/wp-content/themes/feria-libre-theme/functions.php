<?php
/**
 * Feria Libre - Funciones del tema
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Configuracion basica del tema
 */
function feria_libre_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'woocommerce' );

    register_nav_menus( array(
        'primary' => __( 'Menu principal', 'feria-libre' ),
    ) );
}
add_action( 'after_setup_theme', 'feria_libre_setup' );

/**
 * Encolar estilos y scripts
 */
function feria_libre_enqueue_assets() {
    $theme_version = wp_get_theme()->get( 'Version' );

    wp_enqueue_style(
        'feria-libre-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'feria-libre-main',
        get_template_directory_uri() . '/assets/css/feria-libre.css',
        array( 'feria-libre-fonts' ),
        $theme_version
    );

    wp_enqueue_script(
        'feria-libre-app',
        get_template_directory_uri() . '/assets/js/feria-libre.js',
        array(),
        $theme_version,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'feria_libre_enqueue_assets' );
