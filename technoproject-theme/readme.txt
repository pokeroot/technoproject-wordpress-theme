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

La estructura actual del tema es la siguiente:

technoproject-theme/
├── assets/               # Assets específicos de WordPress (CSS, JS, imágenes compiladas de React)
│   └── dist/             # Directorio para los archivos compilados de producción de React (generado por Webpack)
├── docs/                 # Documentación del proyecto (pendiente)
│   ├── api/
│   ├── architecture/
│   └── deployment/
├── includes/             # Funcionalidad backend de WordPress
│   ├── admin-panels/     # (Directorio vacío, pendiente)
│   ├── api-endpoints/
│   │   └── Technoproject_Courses_Controller.php
│   ├── auth/             # (Directorio vacío, pendiente)
│   ├── custom-post-types/
│   │   └── course-cpt.php
│   ├── integrations/     # (Directorio vacío, pendiente)
│   ├── security/         # (Directorio vacío, pendiente)
│   └── taxonomies/
│       ├── course-category-taxonomy.php
│       └── skill-tag-taxonomy.php
├── src/                  # Código fuente de la aplicación React
│   ├── assets/           # Assets específicos de React (imágenes, fuentes, etc.)
│   │   ├── fonts/        # (Directorio vacío, pendiente)
│   │   ├── icons/        # (Directorio vacío, pendiente)
│   │   ├── images/       # (Directorio vacío, pendiente)
│   │   └── videos/       # (Directorio vacío, pendiente)
│   ├── components/       # Componentes de React
│   │   ├── atoms/
│   │   │   └── Button/
│   │   │       ├── Button.module.scss
│   │   │       ├── Button.tsx
│   │   │       └── index.ts
│   │   ├── molecules/    # (Directorio vacío, pendiente)
│   │   ├── organisms/    # (Directorio vacío, pendiente)
│   │   ├── pages/        # (Directorio vacío, pendiente)
│   │   └── templates/    # (Directorio vacío, pendiente)
│   ├── contexts/         # Contextos de React (Directorio vacío, pendiente)
│   ├── hooks/            # Hooks personalizados de React (Directorio vacío, pendiente)
│   ├── services/         # Lógica de servicios (API, storage, external)
│   │   ├── api/          # (Directorio vacío, pendiente)
│   │   ├── external/     # (Directorio vacío, pendiente)
│   │   └── storage/      # (Directorio vacío, pendiente)
│   ├── styles/           # Estilos SCSS (globales, temas)
│   │   ├── components/   # (Directorio vacío, pendiente)
│   │   ├── globals/      # (Directorio vacío, pendiente)
│   │   └── themes/       # (Directorio vacío, pendiente)
│   ├── types/            # Definiciones de TypeScript
│   │   └── user.types.ts
│   ├── utils/            # Funciones de utilidad
│   │   ├── constants/    # (Directorio vacío, pendiente)
│   │   ├── formatters/   # (Directorio vacío, pendiente)
│   │   ├── helpers/      # (Directorio vacío, pendiente)
│   │   └── validators/   # (Directorio vacío, pendiente)
│   └── index.html        # Plantilla HTML base para webpack-dev-server
├── templates/            # Plantillas PHP de WordPress (Directorio vacío, pendiente)
│   ├── archive-templates/
│   ├── page-templates/
│   └── single-templates/
├── tests/                # Pruebas (unitarias, integración, E2E) (Directorio vacío, pendiente)
│   ├── e2e/
│   ├── integration/
│   └── unit/
├── .eslintrc.json        # Configuración de ESLint
├── .prettierrc.json      # Configuración de Prettier
├── functions.php         # Funciones principales del tema
├── index.php             # Plantilla principal de fallback
├── package.json          # Dependencias y scripts de Node.js
├── readme.txt            # Este archivo
├── style.css             # Información principal del tema y estilos CSS de WordPress
├── tsconfig.json         # Configuración de TypeScript
├── webpack.common.js     # Configuración común de Webpack
├── webpack.dev.js        # Configuración de Webpack para desarrollo
└── webpack.prod.js       # Configuración de Webpack para producción

== Avances Recientes ==

En la configuración y desarrollo inicial, se ha completado lo siguiente:

*   **Estructura del Tema:** Configuración completa de directorios para WordPress y React.
*   **Archivos Base de WordPress:** Creación de `style.css`, `index.php`, `functions.php`.
*   **Entorno Frontend:**
    *   `package.json` con dependencias (React, TypeScript, Webpack, ESLint, Prettier, etc.) y scripts.
    *   Configuración de TypeScript (`tsconfig.json`).
    *   Configuración de Webpack para desarrollo y producción, incluyendo `src/index.html` base.
    *   Configuración de ESLint (`.eslintrc.json`) y Prettier (`.prettierrc.json`).
*   **Backend de WordPress (Fundamentos de Cursos):**
    *   Custom Post Type: 'course' (`includes/custom-post-types/course-cpt.php`).
    *   Taxonomías para Cursos:
        *   'course_category' (jerárquica) (`includes/taxonomies/course-category-taxonomy.php`).
        *   'skill_tag' (no jerárquica) (`includes/taxonomies/skill-tag-taxonomy.php`).
    *   API REST Básica para Cursos: Endpoint `GET /wp-json/technoproject/v1/courses` (`includes/api-endpoints/Technoproject_Courses_Controller.php`) para listar cursos.
*   **Frontend (React - Fundamentos):**
    *   Tipos TypeScript para Usuarios: `User`, `Student`, `Instructor` en `src/types/user.types.ts`.
    *   Componente Atómico: `Button` (`src/components/atoms/Button/`).

== Próximos Pasos ==

Continuando con la Fase 1 (Fundación) y el inicio de la Fase 2 (Funcionalidades Core):

1.  **Desarrollo Backend (WordPress):**
    *   **Metafields para Cursos:** Definir y registrar campos personalizados para el CPT `course` (ej: `shortDescription`, `format`, `duration`, `level`, `price`, etc.) usando ACF o metaboxes.
    *   **Mejorar API `GET /courses`:** Incluir metafields y taxonomías en la respuesta del endpoint de cursos.
    *   **CPT `session`:** Crear el Custom Post Type para `session` y asociarlo a `course`.
    *   **Roles de Usuario Personalizados:** Implementar `student`, `instructor`, `course_manager`.
    *   **Sistema de Caching:** Desarrollar la estrategia de caching (Redis, etc.).
2.  **Desarrollo Frontend (React):**
    *   **Archivos Globales SCSS:** Crear `src/styles/settings/_variables.scss` y `src/styles/tools/_mixins.scss`.
    *   **Más Componentes Atómicos:** Implementar `Input`, `Icon`, `Typography`.
    *   **Tipos TypeScript:** Definir tipos para `Course`, `Session`, `Payment`, `API responses`.
    *   **Servicios API:** Crear `courseAPI.ts` para interactuar con el backend.
    *   **Contextos Principales:** Implementar `AuthContext.tsx` y `CourseContext.tsx`.
    *   **Hooks Personalizados:** Desarrollar `useAuth.ts`, `useCourse.ts`.
    *   **Routing Básico:** Configurar `AppRouter.tsx` con páginas iniciales.
3.  **Build y Entorno de Desarrollo:**
    *   **Instalar Dependencias:** Ejecutar `npm install` y `composer install` (si aplica).
    *   **Probar Webpack Dev Server:** Ejecutar `npm start` y verificar la compilación inicial.
4.  **Integraciones Externas:** Planificar e iniciar la integración con servicios como Stripe, HubSpot.
5.  **Seguridad:** Continuar implementando las medidas de seguridad descritas en la arquitectura.
6.  **Testing:** Empezar a desarrollar pruebas unitarias para los componentes y lógica creados.

== Instalación ==

1.  Sube la carpeta `technoproject-theme` a tu directorio `wp-content/themes/`.
2.  Activa el tema "Technoproject" desde el panel de administración de WordPress en "Apariencia" -> "Temas".
3.  Asegúrate de tener las dependencias necesarias (Node.js, Composer) si vas a desarrollar activamente.
4.  Ejecuta `npm install` y `composer install` dentro del directorio del tema para instalar las dependencias de desarrollo.
