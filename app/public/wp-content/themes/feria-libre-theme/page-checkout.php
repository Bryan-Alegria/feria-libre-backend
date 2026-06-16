<?php
/**
 * Template Name: Checkout Flow
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

if ( ! is_user_logged_in() ) {
    echo '<div class="fl-content">';
    echo '<p class="fl-empty">' . esc_html__( 'Debes iniciar sesion para completar tu compra.', 'feria-libre' ) . '</p>';
    echo '</div>';
    get_footer();
    return;
}

$cart = WC()->cart;

if ( $cart->is_empty() ) {
    echo '<div class="fl-content">';
    echo '<p class="fl-empty">' . esc_html__( 'Tu carrito esta vacio.', 'feria-libre' ) . '</p>';
    echo '</div>';
    get_footer();
    return;
}

$current_user = wp_get_current_user();
$subtotal = $cart->get_subtotal();
$total = $cart->get_total( 'edit' );
?>

<div class="fl-checkout-header">
    <h1 class="fl-checkout-title"><?php esc_html_e( 'Finalizar compra', 'feria-libre' ); ?></h1>
    <p class="fl-checkout-subtitle"><?php esc_html_e( 'Revisa tu pedido y paga con Flow', 'feria-libre' ); ?></p>
</div>

<div class="fl-checkout-section">
    <h2 class="fl-section-title"><?php esc_html_e( 'Resumen del pedido', 'feria-libre' ); ?></h2>
    
    <div class="fl-checkout-items">
        <?php foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) :
            $product = $cart_item['data'];
            $quantity = $cart_item['quantity'];
            $product_name = $product->get_name();
            $product_price = $product->get_price();
            $line_total = $product_price * $quantity;
            $product_image = wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' );
        ?>
        <div class="fl-checkout-item">
            <div class="fl-checkout-item-img">
                <?php if ( $product_image ) : ?>
                    <img src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product_name ); ?>">
                <?php else : ?>
                    <span class="fl-product-placeholder">📦</span>
                <?php endif; ?>
            </div>
            <div class="fl-checkout-item-info">
                <h3 class="fl-checkout-item-name"><?php echo esc_html( $product_name ); ?></h3>
                <p class="fl-checkout-item-qty"><?php printf( esc_html__( 'Cantidad: %d', 'feria-libre' ), esc_html( $quantity ) ); ?></p>
            </div>
            <div class="fl-checkout-item-price">
                <?php echo esc_html( wc_price( $line_total ) ); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="fl-checkout-section">
    <div class="fl-checkout-summary">
        <div class="fl-checkout-summary-row">
            <span><?php esc_html_e( 'Subtotal', 'feria-libre' ); ?></span>
            <span><?php echo esc_html( wc_price( $subtotal ) ); ?></span>
        </div>
        <div class="fl-checkout-summary-row fl-checkout-summary-total">
            <span><?php esc_html_e( 'Total a pagar', 'feria-libre' ); ?></span>
            <span><?php echo esc_html( wc_price( $total ) ); ?></span>
        </div>
    </div>
</div>

<div class="fl-checkout-section">
    <div class="fl-checkout-payment-info">
        <div class="fl-checkout-payment-icon">💳</div>
        <div class="fl-checkout-payment-text">
            <strong><?php esc_html_e( 'Pago seguro con Flow', 'feria-libre' ); ?></strong>
            <p><?php esc_html_e( 'Seras redirigido a Flow para completar el pago de forma segura.', 'feria-libre' ); ?></p>
        </div>
    </div>
</div>

<div class="fl-checkout-actions">
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <?php wp_nonce_field( 'feria_libre_checkout', 'feria_libre_nonce' ); ?>
        <input type="hidden" name="action" value="feria_libre_process_checkout">
        
        <button type="submit" class="fl-btn fl-btn-aloe fl-btn-full">
            <?php printf( esc_html__( 'Pagar %s con Flow', 'feria-libre' ), esc_html( wc_price( $total ) ) ); ?>
        </button>
    </form>
    
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="fl-btn fl-btn-outline fl-btn-full">
        <?php esc_html_e( 'Volver al carrito', 'feria-libre' ); ?>
    </a>
</div>

<?php get_footer(); ?>
