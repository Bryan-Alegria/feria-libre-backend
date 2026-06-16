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

/**
 * JWT Authentication Helpers
 */

/**
 * Obtener token JWT del header Authorization
 */
function feria_libre_get_jwt_token() {
    $headers = getallheaders();
    
    if ( isset( $headers['Authorization'] ) ) {
        $auth_header = $headers['Authorization'];
        if ( preg_match( '/Bearer\s(\S+)/', $auth_header, $matches ) ) {
            return $matches[1];
        }
    }
    
    return null;
}

/**
 * Validar token JWT y obtener usuario
 */
function feria_libre_validate_jwt_token( $token ) {
    if ( ! class_exists( 'JWT_Auth' ) ) {
        return new WP_Error( 'jwt_not_available', 'JWT plugin no disponible' );
    }
    
    $jwt_auth = JWT_Auth::get_instance();
    $decoded = $jwt_auth->validate_token( $token );
    
    if ( is_wp_error( $decoded ) ) {
        return $decoded;
    }
    
    $user = get_user_by( 'id', $decoded->data->user->id );
    
    if ( ! $user ) {
        return new WP_Error( 'user_not_found', 'Usuario no encontrado' );
    }
    
    return $user;
}

/**
 * Obtener usuario autenticado por JWT
 */
function feria_libre_get_jwt_user() {
    $token = feria_libre_get_jwt_token();
    
    if ( ! $token ) {
        return null;
    }
    
    $user = feria_libre_validate_jwt_token( $token );
    
    if ( is_wp_error( $user ) ) {
        return null;
    }
    
    return $user;
}

/**
 * Hacer request autenticado a REST API
 */
function feria_libre_api_request( $endpoint, $method = 'GET', $data = array() ) {
    $token = feria_libre_get_jwt_token();
    
    $args = array(
        'method'  => $method,
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    );
    
    if ( $token ) {
        $args['headers']['Authorization'] = 'Bearer ' . $token;
    }
    
    if ( ! empty( $data ) && in_array( $method, array( 'POST', 'PUT', 'PATCH' ) ) ) {
        $args['body'] = wp_json_encode( $data );
    }
    
    $url = rest_url( $endpoint );
    $response = wp_remote_request( $url, $args );
    
    if ( is_wp_error( $response ) ) {
        return $response;
    }
    
    $body = wp_remote_retrieve_body( $response );
    return json_decode( $body, true );
}

/**
 * Exponer datos del usuario actual via REST API
 */
function feria_libre_register_rest_routes() {
    register_rest_route( 'feria-libre/v1', '/user', array(
        'methods'             => 'GET',
        'callback'            => 'feria_libre_get_current_user_data',
        'permission_callback' => function() {
            return is_user_logged_in();
        },
    ) );
    
    register_rest_route( 'feria-libre/v1', '/seller/stats', array(
        'methods'             => 'GET',
        'callback'            => 'feria_libre_get_seller_stats',
        'permission_callback' => function() {
            if ( ! is_user_logged_in() ) {
                return false;
            }
            if ( ! function_exists( 'dokan_is_user_seller' ) ) {
                return false;
            }
            return dokan_is_user_seller( get_current_user_id() );
        },
    ) );
}
add_action( 'rest_api_init', 'feria_libre_register_rest_routes' );

/**
 * Obtener datos del usuario actual
 */
function feria_libre_get_current_user_data() {
    $user = wp_get_current_user();
    
    $data = array(
        'id'           => $user->ID,
        'username'     => $user->user_login,
        'email'        => $user->user_email,
        'display_name' => $user->display_name,
        'is_seller'    => function_exists( 'dokan_is_user_seller' ) ? dokan_is_user_seller( $user->ID ) : false,
    );
    
    return rest_ensure_response( $data );
}

/**
 * Obtener estadísticas del vendedor
 */
function feria_libre_get_seller_stats() {
    $user_id = get_current_user_id();
    
    if ( ! function_exists( 'dokan_get_seller_stats' ) ) {
        return new WP_Error( 'dokan_not_available', 'Dokan no disponible', array( 'status' => 500 ) );
    }
    
    $stats = dokan_get_seller_stats( $user_id );
    
    return rest_ensure_response( $stats );
}
