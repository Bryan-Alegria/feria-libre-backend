# Feria Libre Digital Marketplace

## Objetivo del Proyecto

MVP académico de marketplace local para Puente Alto, Chile, conectando vendedores y compradores a través de una interfaz moderna y responsive. El proyecto busca digitalizar la experiencia de feria libre tradicional, facilitando el comercio local con tecnología accesible.

## Stack Tecnológico

- **CMS:** WordPress 6.x
- **E-commerce:** WooCommerce
- **Multi-vendor:** Dokan Lite
- **Autenticación:** JWT Authentication for WP REST API
- **Pasarela de Pago:** Flow (Chile)
- **Entorno de Desarrollo:** Local by Flywheel

## Sistema de Diseño

Implementación basada en **Shopify Design System** (tokens definidos en `docs/DESIGN-shopify.md`):

- **Tipografía:** Inter (400-600 weight)
- **Paleta de colores:**
  - Canvas cream (#fbfbf5)
  - Primary black (#000000)
  - Accent aloe (#c1fbd4)
  - Accent pistachio (#d4f9e0)
- **Componentes:** Botones pill, cards con shadow Level 3, spacing tokens consistentes
- **Mobile-first:** Diseño optimizado para dispositivos móviles con experiencia app-like

## Características Clave

### 1. Arquitectura Web Híbrida Responsive
- **Mobile (<1024px):** UI tipo aplicación con bottom navigation
- **Desktop (≥1024px):** Navegación tradicional con header completo
- Transiciones suaves entre breakpoints
- Grid responsive de productos (1-4 columnas según viewport)

### 2. Dashboard de Vendedor (Dokan)
- Estadísticas en tiempo real (ventas, productos, pedidos)
- Gestión de inventario
- Validación de vendedores con `dokan_is_user_seller()`
- Interfaz optimizada para móviles

### 3. Integración de Pasarela de Pago (Flow)
- Checkout personalizado con resumen de pedido
- Procesamiento seguro de órdenes WooCommerce
- Redirección a Flow para pago
- Validación de nonce en todos los formularios

### 4. Seed Data Automatizado
- Script `scripts/seed-data.php` para poblado rápido
- 3 vendedores de prueba (Puente Alto)
- 10 productos de ejemplo con imágenes placeholder
- 5 categorías predefinidas
- Idempotente (no crea duplicados)

## Estructura del Tema

```
feria-libre-theme/
├── style.css              # Cabecera del tema
├── functions.php          # Setup, enqueue, JWT helpers, checkout handler
├── header.php             # Navegación dual (desktop/mobile)
├── footer.php             # Footer dual (desktop/mobile)
├── front-page.php         # Home dinámico con productos WooCommerce
├── index.php              # Template fallback
├── page-perfil.php        # Dashboard de vendedor
├── page-checkout.php      # Checkout con integración Flow
├── assets/
│   ├── css/
│   │   └── feria-libre.css  # Design system completo (responsive)
│   └── js/
│       └── feria-libre.js   # Interacciones (chips, navegación)
└── scripts/
    └── seed-data.php      # Script de seed data
```

## Instalación y Configuración

### Requisitos Previos
- WordPress 6.x
- WooCommerce (activo)
- Dokan Lite (activo)
- JWT Authentication for WP REST API (activo)

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/Bryan-Alegria/feria-libre-backend.git
   ```

2. **Activar el tema**
   - Panel WordPress → Apariencia → Temas → Activar "Feria Libre"

3. **Configurar WooCommerce**
   - Configurar moneda (CLP - Peso Chileno)
   - Configurar zonas de envío (Puente Alto)

4. **Configurar Dokan**
   - Habilitar registro de vendedores
   - Configurar comisiones (0% para este MVP)

5. **Ejecutar Seed Data (opcional)**
   ```bash
   cd app/public
   wp eval-file wp-content/themes/feria-libre-theme/scripts/seed-data.php --allow-root
   ```
   
   O via navegador (solo desarrollo):
   ```
   http://tusitio.local/wp-content/themes/feria-libre-theme/scripts/seed-data.php?seed_key=feria_libre_2024
   ```

6. **Configurar Flow (producción)**
   - Obtener API keys de Flow
   - Configurar en `functions.php` (handler `feria_libre_process_checkout`)

## Endpoints REST API Personalizados

### GET /wp-json/feria-libre/v1/user
Retorna datos del usuario autenticado.

**Requiere:** Autenticación JWT

**Respuesta:**
```json
{
  "id": 1,
  "username": "vendor_maria",
  "email": "maria@example.com",
  "display_name": "María González",
  "is_seller": true
}
```

### GET /wp-json/feria-libre/v1/seller/stats
Retorna estadísticas del vendedor (solo vendedores Dokan).

**Requiere:** Autenticación JWT + rol de vendedor

**Respuesta:**
```json
{
  "balance": "150000",
  "earnings": "500000",
  "products": 10,
  "orders": 25
}
```

## Seguridad

- ✅ Validación de nonce en todos los formularios
- ✅ Escapado de output con `esc_html()`, `esc_attr()`, `esc_url()`
- ✅ Verificación de permisos en áreas de vendedor
- ✅ Sanitización de inputs con `sanitize_text_field()`
- ✅ JWT para autenticación de API
- ✅ Protección de script de seed data

## Hitos Completados

1. **Hito 1:** Setup inicial (WordPress, WooCommerce, Dokan)
2. **Hito 2:** App Shell (header, footer, estilos base)
3. **Hito 3:** Home page dinámica con productos WooCommerce
4. **Hito 4:** Dashboard de vendedor con integración Dokan
5. **Hito 5:** Checkout con integración Flow
6. **Hito 6:** Seed data y finalización

## Licencia

GPL v2 o posterior

## Equipo

Proyecto académico - Ingeniería en Informática, INACAP 2024
