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

/**
 * Procesar checkout y redirigir a Flow
 */
function feria_libre_process_checkout() {
    if ( ! isset( $_POST['feria_libre_nonce'] ) || ! wp_verify_nonce( $_POST['feria_libre_nonce'], 'feria_libre_checkout' ) ) {
        wp_die( esc_html__( 'Error de seguridad. Por favor, recarga la pagina.', 'feria-libre' ) );
    }

    if ( ! is_user_logged_in() ) {
        wp_die( esc_html__( 'Debes iniciar sesion para completar tu compra.', 'feria-libre' ) );
    }

    $cart = WC()->cart;

    if ( $cart->is_empty() ) {
        wp_die( esc_html__( 'Tu carrito esta vacio.', 'feria-libre' ) );
    }

    $order_id = wc_create_order( array(
        'customer_id' => get_current_user_id(),
        'status'      => 'pending',
    ) );

    if ( is_wp_error( $order_id ) ) {
        wp_die( esc_html__( 'Error al crear la orden. Por favor, intenta nuevamente.', 'feria-libre' ) );
    }

    $order = wc_get_order( $order_id );

    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
        $quantity = $cart_item['quantity'];
        $order->add_product( $product, $quantity );
    }

    $order->calculate_totals();
    $order->save();

    $cart->empty_cart();

    $flow_url = add_query_arg( array(
        'order_id' => $order_id,
        'amount'   => $order->get_total(),
        'email'    => $order->get_billing_email(),
    ), home_url( '/flow-payment/' ) );

    wp_redirect( esc_url_raw( $flow_url ) );
    exit;
}
add_action( 'admin_post_feria_libre_process_checkout', 'feria_libre_process_checkout' );
add_action( 'admin_post_nopriv_feria_libre_process_checkout', 'feria_libre_process_checkout' );
