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
├── assets/
│   └── dist/             # Generado por `npm run build`
├── docs/                 # (Pendiente)
├── includes/
│   ├── api-endpoints/
│   │   └── Technoproject_Courses_Controller.php
│   ├── custom-post-types/
│   │   └── course-cpt.php
│   └── taxonomies/
│       ├── course-category-taxonomy.php
│       └── skill-tag-taxonomy.php
├── src/
│   ├── assets/           # Assets específicos de React (Pendiente)
│   ├── components/
│   │   ├── atoms/
│   │   │   └── Button/
│   │   │       ├── Button.module.scss
│   │   │       ├── Button.tsx
│   │   │       └── index.ts
│   │   ├── molecules/
│   │   │   └── CourseCard/
│   │   │       ├── CourseCard.module.scss
│   │   │       ├── CourseCard.tsx
│   │   │       └── index.ts
│   │   └── organisms/
│   │       └── CourseList/
│   │           ├── CourseList.module.scss
│   │           ├── CourseList.tsx
│   │           └── index.ts
│   ├── contexts/         # (Pendiente)
│   ├── hooks/            # (Pendiente)
│   ├── services/         # (Pendiente)
│   ├── styles/
│   │   ├── globals/
│   │   │   └── main.scss
│   │   ├── settings/
│   │   │   └── _variables.scss
│   │   └── tools/
│   │       └── _mixins.scss
│   ├── types/
│   │   ├── course.types.ts
│   │   └── user.types.ts
│   ├── index.html        # Plantilla HTML base para Webpack
│   └── index.tsx         # Punto de entrada de la aplicación React
├── templates/            # (Pendiente)
├── tests/                # (Pendiente)
├── .eslintrc.json
├── .prettierrc.json
├── functions.php
├── index.php
├── package.json
├── package-lock.json     # (O yarn.lock)
├── readme.txt
├── style.css
├── tsconfig.json
├── webpack.common.js
├── webpack.dev.js
└── webpack.prod.js

== Avances Recientes ==

Se ha completado una fase significativa de configuración y desarrollo inicial, logrando:

*   **Estructura Completa del Tema:**
    *   Configuración de directorios para WordPress y la aplicación React.
    *   Archivos base de WordPress (`style.css`, `index.php`, `functions.php`).

*   **Entorno de Desarrollo Frontend Funcional:**
    *   `package.json`: Definición de dependencias (React, TypeScript, Webpack, Sass, ESLint, Prettier) y scripts.
        *   Ajuste `--max-old-space-size` en scripts para mitigar errores de memoria de Wasm con Webpack.
    *   `tsconfig.json`: Configuración del compilador de TypeScript.
    *   Configuración de Webpack:
        *   Archivos `webpack.common.js`, `webpack.dev.js`, `webpack.prod.js`.
        *   `src/index.html` como plantilla base.
        *   Proxy configurado en `webpack.dev.js` para redirigir peticiones API a `https://technoproject.com.co`, permitiendo el desarrollo local contra el backend real.
    *   ESLint y Prettier: Configuraciones para calidad y consistencia de código.
    *   SCSS Globales: Creación de `_variables.scss`, `_mixins.scss`, y `main.scss` (importado en `index.tsx`) para resolver errores de importación de estilos y establecer una base de diseño.

*   **Backend de WordPress - Funcionalidades de Cursos:**
    *   Custom Post Type (CPT): 'course', con su UI de administración visible (ajustando `capability_type` a 'post' para diagnóstico y funcionamiento inicial).
    *   Metafields para Cursos: `_technoproject_short_description`, `_technoproject_level`, `_technoproject_format` registrados y expuestos en la API REST.
    *   Taxonomías para Cursos: 'course_category' (jerárquica) y 'skill_tag' (no jerárquica), asociadas al CPT 'course' y expuestas en la API REST.
    *   API REST de Cursos (`GET /wp-json/technoproject/v1/courses`):
        *   Implementación del controlador `Technoproject_Courses_Controller.php`.
        *   La API ahora devuelve cursos publicados con sus títulos, contenido, metafields personalizados y taxonomías.
        *   Corrección de error fatal 500 relacionado con el manejo de fechas en la respuesta de la API.
    *   Seguridad: Filtro añadido a `functions.php` para restringir el acceso a los endpoints de usuarios (`/wp/v2/users`) solo a administradores.

*   **Frontend React - Visualización de Cursos:**
    *   Tipos TypeScript: Definiciones para `User`, `Student`, `Instructor` (`user.types.ts`) y `Course`, `TaxonomyTerm`, `WPRenderedString` (`course.types.ts`).
    *   Componentes React:
        *   `Button` (átomo): Componente reutilizable.
        *   `CourseCard` (molécula): Para mostrar información de un curso individual.
        *   `CourseList` (organismo): Para obtener y mostrar una lista de `CourseCard` desde la API.
    *   Integración: `CourseList` renderizado en `src/index.tsx`, permitiendo la visualización de cursos desde el backend.

Con estos avances, la aplicación React local puede iniciarse (`npm start`), conectarse a la API del backend, y mostrar una lista de cursos con estilos básicos.

== Próximos Pasos ==

Avanzando con el desarrollo de funcionalidades clave:

1.  **Backend (WordPress):**
    *   **UI para Metafields de Cursos:** Implementar una interfaz amigable en el editor de WordPress para los campos `short_description`, `level`, `format` (usando ACF o metaboxes personalizados).
    *   **Capacidades del CPT `course`:** Revisar y definir correctamente `capability_type` como `'course'` y asegurar que los roles (especialmente administrador) tengan las capacidades necesarias (ej. `edit_courses`, `publish_courses`, etc.).
    *   **Mejorar API `GET /courses`:**
        *   Implementar filtros avanzados (por categoría, nivel, formato, etc.) como se define en la arquitectura.
        *   Asegurar que la URL de la imagen destacada del curso se incluya en la respuesta.
    *   **CPT `session` y `certificate`:** Crear estos CPTs con sus respectivos campos y relaciones.
    *   **Endpoints API Adicionales:** Para inscripciones, progreso, sesiones, certificados, etc.
    *   **Roles de Usuario Personalizados:** Implementar `student`, `instructor`, `course_manager` y sus capacidades.

2.  **Frontend (React):**
    *   **Estilos y Diseño:**
        *   Refinar estilos de `Button`, `CourseCard`, `CourseList`.
        *   Implementar el "Design System" de forma más completa.
        *   Asegurar que la imagen destacada se muestre en `CourseCard`.
    *   **Más Componentes:** Desarrollar `Input`, `Icon`, `Typography` (átomos), y componentes más complejos (moléculas, organismos) según la arquitectura.
    *   **Tipos TypeScript:** Completar definiciones para `Session`, `Payment`, etc.
    *   **Servicios API Refactorizados:** Crear módulos dedicados (ej. `src/services/api/courseService.ts`) para encapsular la lógica de `fetch`.
    *   **Gestión de Estado Global:** Implementar `AuthContext`, `CourseContext`, `UserProgressContext` para manejar estado de la aplicación, autenticación y datos de usuario.
    *   **Routing:** Configurar `react-router-dom` con `AppRouter.tsx` para navegación entre páginas (Home, Catálogo de Cursos, Detalle de Curso, Dashboards).
    *   **Páginas:** Desarrollar `HomePage.tsx`, `CourseCatalogPage.tsx`, `CourseDetailPage.tsx`, etc.
    *   **Autenticación:** Implementar flujo de login/registro/logout interactuando con la API de WordPress (posiblemente JWT).

3.  **Sass Deprecations:**
    *   Actualizar la sintaxis de Sass en todos los archivos `.scss` para usar `@use` y `@forward` en lugar de `@import`.
    *   Reemplazar funciones deprecadas como `darken()` con los nuevos módulos de color (ej. `color.adjust()`).

4.  **Testing:** Iniciar el desarrollo de pruebas unitarias (Jest, React Testing Library) y E2E (Cypress) para los componentes y flujos implementados.

== Instalación ==

1.  Sube la carpeta `technoproject-theme` a tu directorio `wp-content/themes/`.
2.  Activa el tema "Technoproject" desde el panel de administración de WordPress en "Apariencia" -> "Temas".
3.  Asegúrate de tener las dependencias necesarias (Node.js, Composer) si vas a desarrollar activamente.
4.  Ejecuta `npm install` y `composer install` dentro del directorio del tema para instalar las dependencias de desarrollo.
