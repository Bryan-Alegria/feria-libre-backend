# Feria Libre Digital Marketplace

Plataforma de comercio electrónico mobile-first para emprendedores de Puente Alto, Chile.

## Objetivo

Conectar vendedores locales con compradores de la comuna a través de un marketplace accesible, con pagos directos vía Flow y sin comisiones por venta.

## Stack Tecnológico

- **CMS:** WordPress 6.x
- **E-commerce:** WooCommerce
- **Multi-vendor:** Dokan Lite
- **Pasarela de pago:** Flow (Chile)
- **Hosting:** Local by Flywheel (desarrollo)

## Design System

Implementación basada en **Shopify Design Tokens** (`docs/DESIGN-shopify.md`):

- Tipografía: Inter (400-600)
- Paleta: Negro (#000000), Blanco (#FFFFFF), Aloe (#c1fbd4), Pistachio (#d4f9e0)
- Componentes: Cards con shadow Level 3, botones pill, spacing tokens
- Mobile-first: Max-width 430px, touch targets optimizados

## Hitos Completados

### Hito 1: Setup Inicial
- Instalación de WordPress, WooCommerce y Dokan Lite
- Configuración de entorno de desarrollo

### Hito 2: App Shell
- `header.php` - Status bar y navegación superior
- `footer.php` - Bottom navigation
- `style.css` - Cabecera del tema
- `functions.php` - Enqueue de assets

### Hito 3: Home Page Dinámica
- `front-page.php` - Grid de productos con `wc_get_products()`
- Listado de categorías con `get_terms()`
- Hero section y barra de búsqueda

### Hito 4: Dashboard de Vendedor
- `page-perfil.php` - Estadísticas del vendedor
- Integración con `dokan_get_seller_stats()`
- Lista de productos del vendedor
- Verificación de permisos con `dokan_is_user_seller()`

### Hito 5: Checkout con Flow
- `page-checkout.php` - Resumen de pedido
- Procesamiento de orden con `wc_create_order()`
- Redirección a Flow para pago seguro
- Validación de nonce y seguridad

## Estructura del Tema

```
app/public/wp-content/themes/feria-libre-theme/
├── style.css              # Cabecera del tema
├── functions.php          # Setup y handlers
├── header.php             # App shell superior
├── footer.php             # Bottom navigation
├── front-page.php         # Home dinámico
├── index.php              # Template fallback
├── page-perfil.php        # Dashboard vendedor
├── page-checkout.php      # Checkout Flow
└── assets/
    ├── css/
    │   └── feria-libre.css  # Design system completo
    └── js/
        └── feria-libre.js   # Interacciones
```

## Instalación

1. Clonar el repositorio
2. Importar la base de datos de Local by Flywheel
3. Activar el tema "Feria Libre" en WordPress
4. Configurar WooCommerce y Dokan Lite
5. Configurar Flow con API keys (producción)

## Seguridad

- Validación de nonce en todos los formularios
- Escapado de output con `esc_html()` y `esc_attr()`
- Verificación de permisos en áreas de vendedor
- Sanitización de inputs con `sanitize_text_field()`

## Licencia

GPL v2 o posterior
