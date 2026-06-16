<?php
/**
 * Feria Libre - Cabecera del tema
 *
 * @package FeriaLibre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div class="fl-app-shell">

    <div class="fl-status-bar">
        <span class="fl-status-time">9:41</span>
        <div class="fl-status-icons">
            <span>&#x1F4F6;</span>
            <span>&#x1F50B;</span>
        </div>
    </div>

    <header class="fl-app-header">
        <div class="fl-logo">
            <?php esc_html_e( 'Feria', 'feria-libre' ); ?><span>.</span><?php esc_html_e( 'Libre', 'feria-libre' ); ?>
        </div>
        <div class="fl-header-actions">
            <button class="fl-header-icon fl-notif-badge" aria-label="<?php esc_attr_e( 'Notificaciones', 'feria-libre' ); ?>">
                &#x1F514;
            </button>
            <button class="fl-header-icon" aria-label="<?php esc_attr_e( 'Carrito', 'feria-libre' ); ?>">
                &#x1F6D2;
            </button>
        </div>
    </header>

    <main class="fl-screen-body">
