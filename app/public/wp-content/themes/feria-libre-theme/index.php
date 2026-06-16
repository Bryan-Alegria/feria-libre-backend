<?php
/**
 * Feria Libre - Template principal (fallback)
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="fl-content">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h2><?php the_title(); ?></h2>
                <div class="fl-entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e( 'No se encontro contenido.', 'feria-libre' ); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
