=== Technoproject Theme ===
Contributors: Jhon Narvaez
Tags: custom-theme, decoupled, react, university, courses, headless, typescript, enterprise
Requires at least: 5.8
Tested up to: 6.4
Stable tag: 0.1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Technoproject es una solución enterprise de vanguardia diseñada para una plataforma de cursos universitarios híbridos. Combina la flexibilidad de WordPress como sistema de gestión de contenidos (CMS) con la potencia y escalabilidad de React y TypeScript en el frontend. Esta arquitectura híbrida y desacoplada (headless/decoupled) está específicamente diseñada para soportar una plataforma robusta que integra modalidades presenciales y virtuales, cumpliendo con altos estándares de performance, seguridad y experiencia de usuario.

WordPress actúa como el backend para la gestión de contenidos, usuarios y datos, exponiendo su funcionalidad a través de APIs REST. React con TypeScript maneja la interfaz de usuario moderna, reactiva y optimizada.

Principios Arquitectónicos Fundamentales:
*   **Arquitectura Desacoplada (Headless/Decoupled):** Separación clara entre el backend (WordPress) y el frontend (React) para mayor flexibilidad, performance y escalabilidad.
*   **Principio de Responsabilidad Única:** Cada componente del sistema tiene una responsabilidad definida.
*   **Escalabilidad Horizontal y Vertical:** Diseñado para escalar ambas capas (frontend y backend) de manera independiente.
*   **Seguridad por Diseño:** Seguridad integrada en cada aspecto de la arquitectura.

Este tema de WordPress sienta las bases para la plataforma Technoproject.

== Estructura del Tema ==

La estructura inicial de este tema incluye:

technoproject-theme/
├── assets/               # Assets específicos de WordPress (CSS, JS, imágenes compiladas de React)
│   ├── dist/             # Directorio para los archivos compilados de producción de React
│   └── src/              # Código fuente de assets de WP (si aplica, o podría ser para React si no es desacoplado)
├── docs/                 # Documentación del proyecto
│   ├── api/
│   ├── architecture/
│   └── deployment/
├── includes/             # Funcionalidad backend de WordPress
│   ├── admin-panels/
│   ├── api-endpoints/
│   ├── auth/
│   ├── custom-post-types/
│   ├── integrations/
│   └── security/
├── src/                  # Código fuente de la aplicación React
│   ├── assets/           # Assets específicos de React (imágenes, fuentes, etc.)
│   │   ├── fonts/
│   │   ├── icons/
│   │   ├── images/
│   │   └── videos/
│   ├── components/       # Componentes de React
│   │   ├── atoms/
│   │   │   └── Button/   # Ejemplo de componente atómico
│   │   ├── molecules/
│   │   ├── organisms/
│   │   ├── pages/
│   │   └── templates/
│   ├── contexts/         # Contextos de React
│   ├── hooks/            # Hooks personalizados de React
│   ├── services/         # Lógica de servicios (API, storage, external)
│   │   ├── api/
│   │   ├── external/
│   │   └── storage/
│   ├── styles/           # Estilos SCSS (globales, temas)
│   │   ├── components/
│   │   ├── globals/
│   │   └── themes/
│   ├── types/            # Definiciones de TypeScript
│   └── utils/            # Funciones de utilidad
│       ├── constants/
│       ├── formatters/
│       ├── helpers/
│       └── validators/
├── templates/            # Plantillas PHP de WordPress
│   ├── archive-templates/
│   ├── page-templates/
│   └── single-templates/
├── tests/                # Pruebas (unitarias, integración, E2E)
│   ├── e2e/
│   ├── integration/
│   └── unit/
├── functions.php         # Funciones principales del tema
├── index.php             # Plantilla principal de fallback
├── readme.txt            # Este archivo
└── style.css             # Información principal del tema y estilos CSS de WordPress

== Próximos Pasos ==

1.  **Desarrollo del Frontend React:** Implementar los componentes, tipos, hooks, contextos y servicios definidos en la arquitectura.
2.  **Desarrollo del Backend WordPress:**
    *   Crear los Custom Post Types (Cursos, Sesiones, Certificados).
    *   Desarrollar los endpoints de la API REST personalizada.
    *   Implementar los roles de usuario personalizados.
    *   Configurar las tablas de base de datos personalizadas.
    *   Desarrollar el sistema de caching.
3.  **Configuración del Build (Webpack):** Definir el proceso de compilación para la aplicación React/TypeScript.
4.  **Integraciones Externas:** Conectar con servicios como Stripe, HubSpot, etc.
5.  **Seguridad:** Implementar completamente las medidas de seguridad y encriptación.
6.  **Testing:** Desarrollar pruebas unitarias, de integración y E2E.

== Instalación ==

1.  Sube la carpeta `technoproject-theme` a tu directorio `wp-content/themes/`.
2.  Activa el tema "Technoproject" desde el panel de administración de WordPress en "Apariencia" -> "Temas".
3.  Asegúrate de tener las dependencias necesarias (Node.js, Composer) si vas a desarrollar activamente.
4.  Ejecuta `npm install` y `composer install` dentro del directorio del tema para instalar las dependencias de desarrollo.
