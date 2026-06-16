<?php
/**
 * Feria Libre - Pie de pagina del tema
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

    </main>

    <nav class="fl-bottom-nav">
        <button class="fl-nav-item fl-nav-active" data-nav="inicio">
            <span class="fl-nav-icon">&#x1F3E0;</span>
            <span class="fl-nav-label"><?php esc_html_e( 'Inicio', 'feria-libre' ); ?></span>
        </button>
        <button class="fl-nav-item" data-nav="explorar">
            <span class="fl-nav-icon">&#x1F50D;</span>
            <span class="fl-nav-label"><?php esc_html_e( 'Explorar', 'feria-libre' ); ?></span>
        </button>
        <button class="fl-nav-item" data-nav="carrito">
            <span class="fl-nav-icon">&#x1F6D2;</span>
            <span class="fl-nav-label"><?php esc_html_e( 'Carrito', 'feria-libre' ); ?></span>
        </button>
        <button class="fl-nav-item" data-nav="perfil">
            <span class="fl-nav-icon">&#x1F464;</span>
            <span class="fl-nav-label"><?php esc_html_e( 'Perfil', 'feria-libre' ); ?></span>
        </button>
    </nav>

</div>

<?php wp_footer(); ?>
</body>
</html>
