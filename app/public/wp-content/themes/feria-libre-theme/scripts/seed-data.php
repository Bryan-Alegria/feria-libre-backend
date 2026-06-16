<?php
/**
 * Script de seed data para Feria Libre
 * 
 * Ejecutar via WP-CLI:
 * wp eval-file scripts/seed-data.php --allow-root
 * 
 * O via navegador (solo desarrollo):
 * http://tusitio.local/wp-content/themes/feria-libre-theme/scripts/seed-data.php?seed_key=feria_libre_2024
 * 
 * @package FeriaLibre
 */

// Seguridad: solo ejecutar con flag específico
if ( php_sapi_name() !== 'cli' ) {
    if ( ! isset( $_GET['seed_key'] ) || $_GET['seed_key'] !== 'feria_libre_2024' ) {
        die( 'Acceso denegado. Usa WP-CLI o agrega ?seed_key=feria_libre_2024' );
    }
    
    // Cargar WordPress en contexto web
    require_once dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/wp-load.php';
}

// Verificar que WordPress esté cargado
if ( ! defined( 'ABSPATH' ) ) {
    die( 'WordPress no está cargado' );
}

// Verificar plugins requeridos
if ( ! function_exists( 'dokan' ) ) {
    die( 'Error: Dokan no está activo' );
}

if ( ! class_exists( 'WooCommerce' ) ) {
    die( 'Error: WooCommerce no está activo' );
}

echo "=== Iniciando Seed Data para Feria Libre ===\n\n";

/**
 * Crear categorías de productos
 */
function fl_create_categories() {
    $categories = array(
        'Frutas' => 'Frutas frescas de temporada',
        'Verduras' => 'Verduras y hortalizas locales',
        'Artesanía' => 'Productos artesanales hechos a mano',
        'Panadería' => 'Pan y productos de panadería',
        'Lácteos' => 'Productos lácteos frescos',
    );
    
    $created = array();
    
    foreach ( $categories as $name => $description ) {
        $term = term_exists( $name, 'product_cat' );
        
        if ( ! $term ) {
            $term = wp_insert_term(
                $name,
                'product_cat',
                array(
                    'description' => $description,
                    'slug' => sanitize_title( $name ),
                )
            );
            
            if ( ! is_wp_error( $term ) ) {
                echo "✓ Categoría creada: {$name}\n";
                $created[ $name ] = $term['term_id'];
            } else {
                echo "✗ Error creando categoría {$name}: " . $term->get_error_message() . "\n";
            }
        } else {
            echo "- Categoría ya existe: {$name}\n";
            $created[ $name ] = $term['term_id'];
        }
    }
    
    return $created;
}

/**
 * Crear vendedores Dokan
 */
function fl_create_vendors() {
    $vendors_data = array(
        array(
            'username' => 'vendor_maria',
            'email' => 'maria.gonzalez@ferialibre.local',
            'store_name' => 'Frutas María',
            'first_name' => 'María',
            'last_name' => 'González',
            'address' => 'Av. Concha y Toro 1234, Puente Alto',
            'phone' => '+56 9 1234 5678',
        ),
        array(
            'username' => 'vendor_pedro',
            'email' => 'pedro.soto@ferialibre.local',
            'store_name' => 'Verduras Don Pedro',
            'first_name' => 'Pedro',
            'last_name' => 'Soto',
            'address' => 'Eyzaguirre 567, Puente Alto',
            'phone' => '+56 9 2345 6789',
        ),
        array(
            'username' => 'vendor_ana',
            'email' => 'ana.munoz@ferialibre.local',
            'store_name' => 'Artesanía Ana',
            'first_name' => 'Ana',
            'last_name' => 'Muñoz',
            'address' => 'Av. Gabriela 890, Puente Alto',
            'phone' => '+56 9 3456 7890',
        ),
    );
    
    $created = array();
    
    foreach ( $vendors_data as $vendor ) {
        $user_id = username_exists( $vendor['username'] );
        
        if ( ! $user_id ) {
            $user_id = wp_insert_user( array(
                'user_login' => $vendor['username'],
                'user_email' => $vendor['email'],
                'user_pass' => wp_generate_password( 12, false ),
                'first_name' => $vendor['first_name'],
                'last_name' => $vendor['last_name'],
                'display_name' => $vendor['first_name'] . ' ' . $vendor['last_name'],
                'role' => 'seller',
            ) );
            
            if ( ! is_wp_error( $user_id ) ) {
                // Actualizar datos de tienda Dokan via user meta
                $store_info = array(
                    'store_name' => $vendor['store_name'],
                    'address' => array(
                        'street_1' => $vendor['address'],
                        'city' => 'Puente Alto',
                        'state' => 'Región Metropolitana',
                        'zip' => '8150000',
                        'country' => 'CL',
                    ),
                    'phone' => $vendor['phone'],
                    'show_email' => 'no',
                );
                
                update_user_meta( $user_id, 'dokan_profile_settings', $store_info );
                update_user_meta( $user_id, 'dokan_store_name', $vendor['store_name'] );
                update_user_meta( $user_id, 'dokan_enable_selling', 'yes' );
                
                echo "✓ Vendedor creado: {$vendor['store_name']} (ID: {$user_id})\n";
                $created[ $vendor['username'] ] = $user_id;
            } else {
                echo "✗ Error creando vendedor {$vendor['username']}: " . $user_id->get_error_message() . "\n";
            }
        } else {
            echo "- Vendedor ya existe: {$vendor['username']} (ID: {$user_id})\n";
            $created[ $vendor['username'] ] = $user_id;
        }
    }
    
    return $created;
}

/**
 * Descargar y adjuntar imagen a producto
 */
function fl_attach_product_image( $product_id, $image_url ) {
    $upload_dir = wp_upload_dir();
    $filename = basename( $image_url );
    $file_path = $upload_dir['path'] . '/' . $filename;
    
    // Descargar imagen
    $response = wp_remote_get( $image_url, array( 'timeout' => 30 ) );
    
    if ( is_wp_error( $response ) ) {
        return false;
    }
    
    $image_data = wp_remote_retrieve_body( $response );
    
    if ( empty( $image_data ) ) {
        return false;
    }
    
    // Guardar archivo
    if ( ! file_put_contents( $file_path, $image_data ) ) {
        return false;
    }
    
    // Verificar tipo de archivo
    $filetype = wp_check_filetype( $filename, null );
    
    if ( ! $filetype['type'] ) {
        unlink( $file_path );
        return false;
    }
    
    // Crear attachment
    $attachment = array(
        'post_mime_type' => $filetype['type'],
        'post_title' => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
        'post_content' => '',
        'post_status' => 'inherit',
    );
    
    $attach_id = wp_insert_attachment( $attachment, $file_path, $product_id );
    
    if ( is_wp_error( $attach_id ) ) {
        unlink( $file_path );
        return false;
    }
    
    // Generar metadatos
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    
    // Establecer como imagen destacada
    set_post_thumbnail( $product_id, $attach_id );
    
    return $attach_id;
}

/**
 * Crear productos WooCommerce
 */
function fl_create_products( $vendors, $categories ) {
    $products_data = array(
        // Frutas María
        array(
            'name' => 'Manzanas Rojas (kg)',
            'description' => 'Manzanas rojas frescas de temporada, cultivadas localmente.',
            'price' => '1500',
            'stock' => 50,
            'category' => 'Frutas',
            'vendor' => 'vendor_maria',
            'image' => 'https://picsum.photos/seed/manzanas/600/600.jpg',
        ),
        array(
            'name' => 'Naranjas de Jugo (kg)',
            'description' => 'Naranjas dulces perfectas para jugo natural.',
            'price' => '1200',
            'stock' => 40,
            'category' => 'Frutas',
            'vendor' => 'vendor_maria',
            'image' => 'https://picsum.photos/seed/naranjas/600/600.jpg',
        ),
        array(
            'name' => 'Plátanos (kg)',
            'description' => 'Plátanos maduros y dulces.',
            'price' => '1000',
            'stock' => 60,
            'category' => 'Frutas',
            'vendor' => 'vendor_maria',
            'image' => 'https://picsum.photos/seed/platanos/600/600.jpg',
        ),
        
        // Verduras Don Pedro
        array(
            'name' => 'Tomates (kg)',
            'description' => 'Tomates rojos maduros, perfectos para ensaladas.',
            'price' => '1800',
            'stock' => 45,
            'category' => 'Verduras',
            'vendor' => 'vendor_pedro',
            'image' => 'https://picsum.photos/seed/tomates/600/600.jpg',
        ),
        array(
            'name' => 'Lechugas (unidad)',
            'description' => 'Lechugas frescas y crujientes.',
            'price' => '800',
            'stock' => 30,
            'category' => 'Verduras',
            'vendor' => 'vendor_pedro',
            'image' => 'https://picsum.photos/seed/lechugas/600/600.jpg',
        ),
        array(
            'name' => 'Zanahorias (kg)',
            'description' => 'Zanahorias frescas y dulces.',
            'price' => '1100',
            'stock' => 55,
            'category' => 'Verduras',
            'vendor' => 'vendor_pedro',
            'image' => 'https://picsum.photos/seed/zanahorias/600/600.jpg',
        ),
        
        // Artesanía Ana
        array(
            'name' => 'Tejido a Mano',
            'description' => 'Tejido artesanal hecho a mano con lana natural.',
            'price' => '15000',
            'stock' => 10,
            'category' => 'Artesanía',
            'vendor' => 'vendor_ana',
            'image' => 'https://picsum.photos/seed/tejido/600/600.jpg',
        ),
        array(
            'name' => 'Cerámica Decorativa',
            'description' => 'Pieza de cerámica decorativa pintada a mano.',
            'price' => '12000',
            'stock' => 8,
            'category' => 'Artesanía',
            'vendor' => 'vendor_ana',
            'image' => 'https://picsum.photos/seed/ceramica/600/600.jpg',
        ),
        array(
            'name' => 'Jabones Artesanales (pack 3)',
            'description' => 'Pack de 3 jabones artesanales con ingredientes naturales.',
            'price' => '6000',
            'stock' => 20,
            'category' => 'Artesanía',
            'vendor' => 'vendor_ana',
            'image' => 'https://picsum.photos/seed/jabones/600/600.jpg',
        ),
        array(
            'name' => 'Velas Aromáticas',
            'description' => 'Velas aromáticas hechas a mano con esencias naturales.',
            'price' => '4500',
            'stock' => 25,
            'category' => 'Artesanía',
            'vendor' => 'vendor_ana',
            'image' => 'https://picsum.photos/seed/velas/600/600.jpg',
        ),
    );
    
    foreach ( $products_data as $product_data ) {
        $vendor_id = $vendors[ $product_data['vendor'] ];
        $category_id = $categories[ $product_data['category'] ];
        
        // Verificar si el producto ya existe
        $existing = get_page_by_title( $product_data['name'], OBJECT, 'product' );
        
        if ( $existing ) {
            echo "- Producto ya existe: {$product_data['name']}\n";
            continue;
        }
        
        // Crear producto
        $product_id = wp_insert_post( array(
            'post_title' => $product_data['name'],
            'post_content' => $product_data['description'],
            'post_excerpt' => $product_data['description'],
            'post_status' => 'publish',
            'post_type' => 'product',
            'post_author' => $vendor_id,
        ) );
        
        if ( is_wp_error( $product_id ) ) {
            echo "✗ Error creando producto {$product_data['name']}: " . $product_id->get_error_message() . "\n";
            continue;
        }
        
        // Asignar categoría
        wp_set_object_terms( $product_id, array( $category_id ), 'product_cat' );
        
        // Establecer metadatos de WooCommerce
        update_post_meta( $product_id, '_price', $product_data['price'] );
        update_post_meta( $product_id, '_regular_price', $product_data['price'] );
        update_post_meta( $product_id, '_stock', $product_data['stock'] );
        update_post_meta( $product_id, '_manage_stock', 'yes' );
        update_post_meta( $product_id, '_stock_status', 'instock' );
        update_post_meta( $product_id, '_visibility', 'visible' );
        
        // Descargar y adjuntar imagen
        $image_id = fl_attach_product_image( $product_id, $product_data['image'] );
        
        if ( $image_id ) {
            echo "✓ Producto creado: {$product_data['name']} (ID: {$product_id}) - Imagen adjuntada\n";
        } else {
            echo "✓ Producto creado: {$product_data['name']} (ID: {$product_id}) - Sin imagen\n";
        }
    }
}

// Ejecutar seed
echo "1. Creando categorías...\n";
$categories = fl_create_categories();

echo "\n2. Creando vendedores...\n";
$vendors = fl_create_vendors();

echo "\n3. Creando productos...\n";
fl_create_products( $vendors, $categories );

echo "\n=== Seed Data Completado ===\n";
echo "Resumen:\n";
echo "- Categorías: " . count( $categories ) . "\n";
echo "- Vendedores: " . count( $vendors ) . "\n";
echo "- Productos: 10\n";
echo "\nPara ver los productos, visita: http://tusitio.local/tienda/\n";
