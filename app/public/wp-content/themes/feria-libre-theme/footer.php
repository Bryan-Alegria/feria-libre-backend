<?php
/**
 * Footer del tema Feria Libre
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

    </main>

    <!-- Desktop Footer -->
    <footer class="fl-footer fl-footer-desktop">
        <div class="fl-footer-container">
            
            <div class="fl-footer-grid">
                
                <div class="fl-footer-col">
                    <h3 class="fl-footer-title"><?php esc_html_e( 'Feria Libre', 'feria-libre' ); ?></h3>
                    <p class="fl-footer-text">
                        <?php esc_html_e( 'Marketplace para emprendedores de Puente Alto.', 'feria-libre' ); ?>
                    </p>
                </div>
                
                <div class="fl-footer-col">
                    <h3 class="fl-footer-title"><?php esc_html_e( 'Navegación', 'feria-libre' ); ?></h3>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'fl-footer-links',
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </div>
                
                <div class="fl-footer-col">
                    <h3 class="fl-footer-title"><?php esc_html_e( 'Cuenta', 'feria-libre' ); ?></h3>
                    <ul class="fl-footer-links">
                        <?php if ( is_user_logged_in() ) : ?>
                            <li><a href="<?php echo esc_url( home_url( '/perfil/' ) ); ?>"><?php esc_html_e( 'Mi Perfil', 'feria-libre' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/mis-productos/' ) ); ?>"><?php esc_html_e( 'Mis Productos', 'feria-libre' ); ?></a></li>
                            <li><a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e( 'Cerrar Sesión', 'feria-libre' ); ?></a></li>
                        <?php else : ?>
                            <li><a href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Ingresar', 'feria-libre' ); ?></a></li>
                            <li><a href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Registrarse', 'feria-libre' ); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="fl-footer-col">
                    <h3 class="fl-footer-title"><?php esc_html_e( 'Legal', 'feria-libre' ); ?></h3>
                    <ul class="fl-footer-links">
                        <li><a href="<?php echo esc_url( home_url( '/terminos/' ) ); ?>"><?php esc_html_e( 'Términos', 'feria-libre' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/privacidad/' ) ); ?>"><?php esc_html_e( 'Privacidad', 'feria-libre' ); ?></a></li>
                    </ul>
                </div>
                
            </div>
            
            <div class="fl-footer-bottom">
                <p class="fl-footer-copyright">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. 
                    <?php esc_html_e( 'Todos los derechos reservados.', 'feria-libre' ); ?>
                </p>
            </div>
            
        </div>
    </footer>

    <!-- Mobile Bottom Nav -->
    <nav class="fl-footer fl-footer-mobile">
        <div class="fl-bottom-nav">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fl-bottom-nav-item">
                <span class="fl-bottom-nav-icon">&#x1F3E0;</span>
                <span class="fl-bottom-nav-label"><?php esc_html_e( 'Inicio', 'feria-libre' ); ?></span>
            </a>
            
            <a href="<?php echo esc_url( home_url( '/tienda/' ) ); ?>" class="fl-bottom-nav-item">
                <span class="fl-bottom-nav-icon">&#x1F50D;</span>
                <span class="fl-bottom-nav-label"><?php esc_html_e( 'Explorar', 'feria-libre' ); ?></span>
            </a>
            
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="fl-bottom-nav-item">
                <span class="fl-bottom-nav-icon">&#x1F6D2;</span>
                <span class="fl-bottom-nav-label"><?php esc_html_e( 'Carrito', 'feria-libre' ); ?></span>
            </a>
            
            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo esc_url( home_url( '/perfil/' ) ); ?>" class="fl-bottom-nav-item">
                    <span class="fl-bottom-nav-icon">&#x1F464;</span>
                    <span class="fl-bottom-nav-label"><?php esc_html_e( 'Perfil', 'feria-libre' ); ?></span>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url( wp_login_url() ); ?>" class="fl-bottom-nav-item">
                    <span class="fl-bottom-nav-icon">&#x1F511;</span>
                    <span class="fl-bottom-nav-label"><?php esc_html_e( 'Ingresar', 'feria-libre' ); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </nav>

</div>

<?php wp_footer(); ?>

</body>
</html>
