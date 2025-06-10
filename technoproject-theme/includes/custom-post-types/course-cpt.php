<?php
/**
 * Registers the 'course' custom post type.
 *
 * @package Technoproject
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register Course Custom Post Type
 */
function technoproject_register_course_post_type() {
    $labels = array(
        'name'                  => _x( 'Cursos', 'Post Type General Name', 'technoproject' ),
        'singular_name'         => _x( 'Curso', 'Post Type Singular Name', 'technoproject' ),
        'menu_name'             => __( 'Cursos', 'technoproject' ),
        'name_admin_bar'        => __( 'Curso', 'technoproject' ),
        'archives'              => __( 'Archivo de Cursos', 'technoproject' ),
        'attributes'            => __( 'Atributos del Curso', 'technoproject' ),
        'parent_item_colon'     => __( 'Curso Padre:', 'technoproject' ),
        'all_items'             => __( 'Todos los Cursos', 'technoproject' ),
        'add_new_item'          => __( 'Añadir Nuevo Curso', 'technoproject' ),
        'add_new'               => __( 'Añadir Nuevo', 'technoproject' ),
        'new_item'              => __( 'Nuevo Curso', 'technoproject' ),
        'edit_item'             => __( 'Editar Curso', 'technoproject' ),
        'update_item'           => __( 'Actualizar Curso', 'technoproject' ),
        'view_item'             => __( 'Ver Curso', 'technoproject' ),
        'view_items'            => __( 'Ver Cursos', 'technoproject' ),
        'search_items'          => __( 'Buscar Curso', 'technoproject' ),
        'not_found'             => __( 'No encontrado', 'technoproject' ),
        'not_found_in_trash'    => __( 'No encontrado en la Papelera', 'technoproject' ),
        'featured_image'        => __( 'Imagen Destacada', 'technoproject' ),
        'set_featured_image'    => __( 'Establecer Imagen Destacada', 'technoproject' ),
        'remove_featured_image' => __( 'Eliminar Imagen Destacada', 'technoproject' ),
        'use_featured_image'    => __( 'Usar como Imagen Destacada', 'technoproject' ),
        'insert_into_item'      => __( 'Insertar en Curso', 'technoproject' ),
        'uploaded_to_this_item' => __( 'Subido a este Curso', 'technoproject' ),
        'items_list'            => __( 'Lista de Cursos', 'technoproject' ),
        'items_list_navigation' => __( 'Navegación de Lista de Cursos', 'technoproject' ),
        'filter_items_list'     => __( 'Filtrar Lista de Cursos', 'technoproject' ),
    );
    $args = array(
        'label'                 => __( 'Cursos', 'technoproject' ),
        'description'           => __( 'Post Type para Cursos de Technoproject', 'technoproject' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'author', 'revisions' ), // Added excerpt, author, revisions from common practice
        'taxonomies'            => array( /* 'course_category', 'skill_tag' - will be registered separately */ ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5, // Below Posts
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'cursos', // As per document 'rewrite' => array('slug' => 'cursos')
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'course', // As per document
        'map_meta_cap'          => true,     // As per document
        'show_in_rest'          => true,     // As per document
        'rest_base'             => 'courses',// As per document
        'rest_controller_class' => 'WP_REST_Posts_Controller', // As per document
        'rewrite'               => array( 'slug' => 'cursos', 'with_front' => false ), // Added with_front
    );
    register_post_type( 'course', $args );

    // Register CPT Metafields
    register_post_meta(
        'course',
        '_technoproject_short_description',
        array(
            'type'              => 'string',
            'description'       => 'A short description for the course.',
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );

    register_post_meta(
        'course',
        '_technoproject_level',
        array(
            'type'              => 'string',
            'description'       => 'The difficulty level of the course (e.g., beginner, intermediate, advanced).',
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    register_post_meta(
        'course',
        '_technoproject_format',
        array(
            'type'              => 'string',
            'description'       => 'The format of the course (e.g., online, hybrid, presencial).',
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
}
// Note: The hook add_action( 'init', 'technoproject_register_course_post_type' );
// is in functions.php
