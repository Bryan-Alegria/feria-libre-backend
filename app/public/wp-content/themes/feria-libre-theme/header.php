<?php
/**
 * Header del tema Feria Libre
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <header class="fl-header">
        
        <!-- Desktop Navigation -->
        <nav class="fl-nav-bar fl-nav-desktop">
            <div class="fl-nav-container">
                <div class="fl-nav-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </div>
                
                <div class="fl-nav-menu">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'fl-nav-list',
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </div>
                
                <div class="fl-nav-actions">
                    <?php if ( is_user_logged_in() ) : ?>
                        <?php if ( function_exists( 'dokan_is_user_seller' ) && dokan_is_user_seller( get_current_user_id() ) ) : ?>
                            <a href="<?php echo esc_url( home_url( '/perfil/' ) ); ?>" class="fl-btn fl-btn-outline">
                                <?php esc_html_e( 'Mi Tienda', 'feria-libre' ); ?>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="fl-btn fl-btn-primary">
                            <?php esc_html_e( 'Salir', 'feria-libre' ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( wp_login_url() ); ?>" class="fl-btn fl-btn-outline">
                            <?php esc_html_e( 'Ingresar', 'feria-libre' ); ?>
                        </a>
                        <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="fl-btn fl-btn-primary">
                            <?php esc_html_e( 'Registrarse', 'feria-libre' ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        
        <!-- Mobile App Header -->
        <div class="fl-nav-bar fl-nav-mobile">
            <div class="fl-nav-container">
                <div class="fl-nav-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </div>
                
                <div class="fl-nav-actions">
                    <button class="fl-icon-btn" aria-label="<?php esc_attr_e( 'Notificaciones', 'feria-libre' ); ?>">
                        &#x1F514;
                    </button>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="fl-icon-btn" aria-label="<?php esc_attr_e( 'Carrito', 'feria-libre' ); ?>">
                        &#x1F6D2;
                    </a>
                </div>
            </div>
        </div>
        
    </header>

    <main id="content" class="site-content">
