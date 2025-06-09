<?php
/**
 * Technoproject functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Technoproject
 */

if ( ! defined( 'TECHNOPROJECT_VERSION' ) ) {
    // Replace with the actual version of your theme
    define( 'TECHNOPROJECT_VERSION', '0.1.0' );
}

if ( ! function_exists( 'technoproject_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function technoproject_setup() {
        // Make theme available for translation.
        load_theme_textdomain( 'technoproject', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // Register navigation menus.
        register_nav_menus(
            array(
                'primary' => esc_html__( 'Primary Menu', 'technoproject' ),
            )
        );

        // Switch default core markup for search form, comment form, and comments
        // to output valid HTML5.
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'technoproject_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        // TODO: Add setup for custom post types, taxonomies, API endpoints etc.
        // referenced in the architecture document.
        // Example: require get_template_directory() . '/includes/custom-post-types/course.php';

        // TODO: Enqueue React app scripts and styles.
        // This will be more complex for a decoupled theme.
        // Example: add_action( 'wp_enqueue_scripts', 'technoproject_enqueue_react_app' );

    }
endif;
add_action( 'after_setup_theme', 'technoproject_setup' );

/**
 * Enqueue scripts and styles.
 */
function technoproject_enqueue_scripts() {
    wp_enqueue_style( 'technoproject-style', get_stylesheet_uri(), array(), TECHNOPROJECT_VERSION );
    // Potentially, scripts for the main theme (not React) would be enqueued here.
    // The React app itself will likely be enqueued differently,
    // possibly loaded via a page template or a specific condition.
}
add_action( 'wp_enqueue_scripts', 'technoproject_enqueue_scripts' );

// Placeholder for enqueuing the React app
// This will need to point to the compiled assets from Webpack
/*
function technoproject_enqueue_react_app() {
    // These paths will depend on your Webpack output configuration
    // For example, if Webpack outputs to `assets/dist/js/main.js` and `assets/dist/css/main.css`
    // within the theme directory.

    // Example:
    // wp_enqueue_script(
    //     'technoproject-react-app',
    //     get_template_directory_uri() . '/assets/dist/js/main.js', // Adjust path as needed
    //     array(), // Dependencies like 'wp-element' if using WordPress packages in React
    //     TECHNOPROJECT_VERSION,
    //     true // Load in footer
    // );

    // wp_enqueue_style(
    //     'technoproject-react-app-styles',
    //     get_template_directory_uri() . '/assets/dist/css/main.css', // Adjust path as needed
    //     array(),
    //     TECHNOPROJECT_VERSION
    // );

    // Pass data to React app if needed (e.g., API endpoints, nonce)
    // wp_localize_script(
    //     'technoproject-react-app',
    //     'technoprojectData',
    //     array(
    //         'apiUrl' => esc_url_raw( rest_url() ),
    //         'nonce' => wp_create_nonce( 'wp_rest' ),
    //         // Add other data needed by your React app
    //     )
    // );
}
// Consider how and where to call this, e.g., on a specific page template.
// add_action( 'wp_enqueue_scripts', 'technoproject_enqueue_react_app' );
*/

// Require other function files from /includes folder as needed
// Example:
// require_once get_template_directory() . '/includes/theme-settings.php';
// require_once get_template_directory() . '/includes/api-endpoints/course-endpoints.php';


// --- Initialize Custom Post Types, Taxonomies, APIs from the architecture document ---
// (These would be calls to files within the 'includes' directory)

// Example CPT registration (structure taken from document 4.1)
// require_once get_template_directory() . '/includes/custom-post-types/course-post-type.php';
// add_action( 'init', 'register_course_post_type' ); // Assuming function is in the required file

// Example Custom Roles (structure taken from document 4.3)
// require_once get_template_directory() . '/includes/user-roles.php';
// add_action( 'init', 'add_technoproject_user_roles' );

// Example API registration (structure taken from document 4.2)
// require_once get_template_directory() . '/includes/api-endpoints/Technoproject_Courses_Controller.php';
// add_action( 'rest_api_init', function () {
//     $controller = new Technoproject_Courses_Controller();
//     $controller->register_routes();
// });

// Example Security Headers (structure taken from document 6.3)
// require_once get_template_directory() . '/includes/security/class-security-headers.php';
// new Technoproject_Security_Headers();

// Example Data Encryption (structure taken from document 6.3)
// require_once get_template_directory() . '/includes/security/class-data-encryption.php';
// global $technoproject_encryption;
// $technoproject_encryption = new Technoproject_Data_Encryption();

// Example JWT Auth (structure taken from document 6.2)
// require_once get_template_directory() . '/includes/auth/class-jwt-auth.php';
// new Technoproject_JWT_Auth();

?>
