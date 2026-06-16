<?php
/**
 * Feria Libre - Pagina de inicio dinamica
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$productos = wc_get_products( array(
    'status'  => 'publish',
    'limit'   => 8,
    'orderby' => 'date',
    'order'   => 'DESC',
) );

$categorias = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'number'     => 6,
) );
?>

<div class="fl-hero">
    <p class="fl-eyebrow"><?php esc_html_e( 'MARCHA BLANCA', 'feria-libre' ); ?></p>
    <h1 class="fl-hero-title"><?php esc_html_e( 'Tu feria, en tu celular', 'feria-libre' ); ?></h1>
    <p class="fl-hero-sub"><?php esc_html_e( 'Vendedores verificados de Puente Alto', 'feria-libre' ); ?></p>
</div>

<div class="fl-search">
    <span class="fl-search-icon">&#x1F50D;</span>
    <input type="text" placeholder="<?php esc_attr_e( 'Busca empanadas, ropa, artesania...', 'feria-libre' ); ?>" class="fl-search-input">
</div>

<?php if ( ! empty( $categorias ) && ! is_wp_error( $categorias ) ) : ?>
<div class="fl-chips">
    <button class="fl-chip fl-chip-active"><?php esc_html_e( 'Todos', 'feria-libre' ); ?></button>
    <?php foreach ( $categorias as $cat ) : ?>
        <button class="fl-chip"><?php echo esc_html( $cat->name ); ?></button>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<h2 class="fl-section-title"><?php esc_html_e( 'Cerca de ti', 'feria-libre' ); ?></h2>

<?php if ( ! empty( $productos ) ) : ?>
<div class="fl-product-grid">
    <?php foreach ( $productos as $producto ) :
        $product = wc_get_product( $producto->get_id() );
        if ( ! $product ) continue;

        $nombre    = $product->get_name();
        $precio    = $product->get_price_html();
        $imagen_id = $product->get_image_id();
        $imagen    = $imagen_id ? wp_get_attachment_image_url( $imagen_id, 'medium' ) : '';
        $permalink = get_permalink( $product->get_id() );
    ?>
    <a href="<?php echo esc_url( $permalink ); ?>" class="fl-product-card">
        <div class="fl-product-img">
            <?php if ( $imagen ) : ?>
                <img src="<?php echo esc_url( $imagen ); ?>" alt="<?php echo esc_attr( $nombre ); ?>">
            <?php else : ?>
                <span class="fl-product-placeholder">&#x1F4E6;</span>
            <?php endif; ?>
        </div>
        <div class="fl-product-info">
            <h3 class="fl-product-name"><?php echo esc_html( $nombre ); ?></h3>
            <p class="fl-product-price"><?php echo wp_kses_post( $precio ); ?></p>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php else : ?>
<p class="fl-empty"><?php esc_html_e( 'No hay productos disponibles en este momento.', 'feria-libre' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
