<?php
/**
 * Registers the 'course_category' taxonomy for the 'course' post type.
 *
 * @package Technoproject
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register Course Category Taxonomy
 */
function technoproject_register_course_category_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Categorías de Cursos', 'Taxonomy General Name', 'technoproject' ),
        'singular_name'              => _x( 'Categoría de Curso', 'Taxonomy Singular Name', 'technoproject' ),
        'menu_name'                  => __( 'Categorías de Cursos', 'technoproject' ),
        'all_items'                  => __( 'Todas las Categorías', 'technoproject' ),
        'parent_item'                => __( 'Categoría Padre', 'technoproject' ),
        'parent_item_colon'          => __( 'Categoría Padre:', 'technoproject' ),
        'new_item_name'              => __( 'Nueva Categoría de Curso', 'technoproject' ),
        'add_new_item'               => __( 'Añadir Nueva Categoría de Curso', 'technoproject' ),
        'edit_item'                  => __( 'Editar Categoría de Curso', 'technoproject' ),
        'update_item'                => __( 'Actualizar Categoría de Curso', 'technoproject' ),
        'view_item'                  => __( 'Ver Categoría de Curso', 'technoproject' ),
        'separate_items_with_commas' => __( 'Separar categorías con comas', 'technoproject' ),
        'add_or_remove_items'        => __( 'Añadir o eliminar categorías de cursos', 'technoproject' ),
        'choose_from_most_used'      => __( 'Elegir de las más usadas', 'technoproject' ),
        'popular_items'              => __( 'Categorías Populares', 'technoproject' ),
        'search_items'               => __( 'Buscar Categorías de Cursos', 'technoproject' ),
        'not_found'                  => __( 'No encontrada', 'technoproject' ),
        'no_terms'                   => __( 'Sin categorías', 'technoproject' ),
        'items_list'                 => __( 'Lista de categorías de cursos', 'technoproject' ),
        'items_list_navigation'      => __( 'Navegación de lista de categorías de cursos', 'technoproject' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true, // Categories are hierarchical
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false, // Usually false for categories
        'show_in_rest'               => true, // Expose this taxonomy in the REST API
        'rest_base'                  => 'course-categories',
        'rest_controller_class'      => 'WP_REST_Terms_Controller',
        'rewrite'                    => array( 'slug' => 'cursos/categoria', 'with_front' => false ),
    );
    register_taxonomy( 'course_category', array( 'course' ), $args ); // Associate with 'course' CPT
}
// The hook add_action( 'init', 'technoproject_register_course_category_taxonomy' );
// will be added to functions.php
