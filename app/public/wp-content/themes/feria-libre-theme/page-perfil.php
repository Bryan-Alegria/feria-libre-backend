<?php
/**
 * Template Name: Perfil Vendedor
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Verificar acceso
if ( ! is_user_logged_in() ) {
    echo '<div class="fl-content">';
    echo '<p class="fl-empty">' . esc_html__( 'Debes iniciar sesion para ver tu perfil.', 'feria-libre' ) . '</p>';
    echo '</div>';
    get_footer();
    return;
}

$current_user_id = get_current_user_id();

// Verificar que sea vendedor de Dokan
if ( ! function_exists( 'dokan_is_user_seller' ) || ! dokan_is_user_seller( $current_user_id ) ) {
    echo '<div class="fl-content">';
    echo '<p class="fl-empty">' . esc_html__( 'No tienes permisos de vendedor.', 'feria-libre' ) . '</p>';
    echo '</div>';
    get_footer();
    return;
}

// Obtener datos del vendedor
$store_info = dokan_get_store_info( $current_user_id );
$store_name = isset( $store_info['store_name'] ) ? $store_info['store_name'] : get_userdata( $current_user_id )->display_name;

// Obtener estadisticas
$stats = array();
if ( function_exists( 'dokan_get_seller_stats' ) ) {
    $stats = dokan_get_seller_stats( $current_user_id );
}

$balance     = isset( $stats['balance'] ) ? $stats['balance'] : 0;
$earnings    = isset( $stats['earnings'] ) ? $stats['earnings'] : 0;
$order_count = isset( $stats['order_count'] ) ? $stats['order_count'] : 0;
$product_count = isset( $stats['products'] ) ? $stats['products'] : 0;

// Obtener productos recientes del vendedor
$productos = array();
if ( function_exists( 'dokan_get_product_list' ) ) {
    $productos = dokan_get_product_list( array(
        'author'    => $current_user_id,
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'orderby'   => 'date',
        'order'     => 'DESC',
    ) );
}
?>

<div class="fl-vendor-header">
    <h1 class="fl-vendor-greeting">
        <?php printf( esc_html__( 'Hola, %s', 'feria-libre' ), esc_html( $store_name ) ); ?>
    </h1>
    <p class="fl-vendor-subtitle"><?php esc_html_e( 'Tu panel de vendedor', 'feria-libre' ); ?></p>
</div>

<div class="fl-stats-grid">
    <div class="fl-stat-card">
        <div class="fl-stat-icon">💰</div>
        <div class="fl-stat-value"><?php echo esc_html( wc_price( $balance ) ); ?></div>
        <div class="fl-stat-label"><?php esc_html_e( 'Saldo disponible', 'feria-libre' ); ?></div>
    </div>

    <div class="fl-stat-card">
        <div class="fl-stat-icon">📦</div>
        <div class="fl-stat-value"><?php echo esc_html( number_format_i18n( $product_count ) ); ?></div>
        <div class="fl-stat-label"><?php esc_html_e( 'Productos', 'feria-libre' ); ?></div>
    </div>

    <div class="fl-stat-card">
        <div class="fl-stat-icon">🛒</div>
        <div class="fl-stat-value"><?php echo esc_html( number_format_i18n( $order_count ) ); ?></div>
        <div class="fl-stat-label"><?php esc_html_e( 'Pedidos', 'feria-libre' ); ?></div>
    </div>

    <div class="fl-stat-card">
        <div class="fl-stat-icon">📈</div>
        <div class="fl-stat-value"><?php echo esc_html( wc_price( $earnings ) ); ?></div>
        <div class="fl-stat-label"><?php esc_html_e( 'Ganancias totales', 'feria-libre' ); ?></div>
    </div>
</div>

<div class="fl-section">
    <h2 class="fl-section-title"><?php esc_html_e( 'Productos recientes', 'feria-libre' ); ?></h2>

    <?php if ( ! empty( $productos ) ) : ?>
        <div class="fl-product-list">
            <?php foreach ( $productos as $producto ) :
                $product = wc_get_product( $producto->ID );
                if ( ! $product ) continue;

                $nombre    = $product->get_name();
                $precio    = $product->get_price_html();
                $stock     = $product->get_stock_quantity();
                $imagen_id = $product->get_image_id();
                $imagen    = $imagen_id ? wp_get_attachment_image_url( $imagen_id, 'thumbnail' ) : '';
                $permalink = get_permalink( $product->ID );
            ?>
            <a href="<?php echo esc_url( $permalink ); ?>" class="fl-product-list-item">
                <div class="fl-product-list-img">
                    <?php if ( $imagen ) : ?>
                        <img src="<?php echo esc_url( $imagen ); ?>" alt="<?php echo esc_attr( $nombre ); ?>">
                    <?php else : ?>
                        <span class="fl-product-placeholder">📦</span>
                    <?php endif; ?>
                </div>
                <div class="fl-product-list-info">
                    <h3 class="fl-product-list-name"><?php echo esc_html( $nombre ); ?></h3>
                    <p class="fl-product-list-price"><?php echo wp_kses_post( $precio ); ?></p>
                    <?php if ( $stock !== null ) : ?>
                        <p class="fl-product-list-stock"><?php printf( esc_html__( 'Stock: %d', 'feria-libre' ), esc_html( $stock ) ); ?></p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="fl-empty"><?php esc_html_e( 'Aun no tienes productos publicados.', 'feria-libre' ); ?></p>
    <?php endif; ?>
</div>

<div class="fl-actions">
    <a href="<?php echo esc_url( home_url( '/mis-productos/' ) ); ?>" class="fl-btn fl-btn-primary">
        <?php esc_html_e( 'Ver todos mis productos', 'feria-libre' ); ?>
    </a>
    <a href="<?php echo esc_url( home_url( '/nuevo-producto/' ) ); ?>" class="fl-btn fl-btn-aloe">
        <?php esc_html_e( 'Publicar nuevo producto', 'feria-libre' ); ?>
    </a>
</div>

<?php get_footer(); ?>
