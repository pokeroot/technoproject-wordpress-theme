<?php
/**
 * Registers the 'skill_tag' taxonomy for the 'course' post type.
 *
 * @package Technoproject
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register Skill Tag Taxonomy
 */
function technoproject_register_skill_tag_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Habilidades (Tags)', 'Taxonomy General Name', 'technoproject' ),
        'singular_name'              => _x( 'Habilidad (Tag)', 'Taxonomy Singular Name', 'technoproject' ),
        'menu_name'                  => __( 'Habilidades (Tags)', 'technoproject' ),
        'all_items'                  => __( 'Todas las Habilidades', 'technoproject' ),
        'parent_item'                => null, // Tags are not hierarchical
        'parent_item_colon'          => null, // Tags are not hierarchical
        'new_item_name'              => __( 'Nueva Habilidad (Tag)', 'technoproject' ),
        'add_new_item'               => __( 'Añadir Nueva Habilidad (Tag)', 'technoproject' ),
        'edit_item'                  => __( 'Editar Habilidad (Tag)', 'technoproject' ),
        'update_item'                => __( 'Actualizar Habilidad (Tag)', 'technoproject' ),
        'view_item'                  => __( 'Ver Habilidad (Tag)', 'technoproject' ),
        'separate_items_with_commas' => __( 'Separar habilidades con comas', 'technoproject' ),
        'add_or_remove_items'        => __( 'Añadir o eliminar habilidades', 'technoproject' ),
        'choose_from_most_used'      => __( 'Elegir de las más usadas', 'technoproject' ),
        'popular_items'              => __( 'Habilidades Populares', 'technoproject' ),
        'search_items'               => __( 'Buscar Habilidades', 'technoproject' ),
        'not_found'                  => __( 'No encontrada', 'technoproject' ),
        'no_terms'                   => __( 'Sin habilidades', 'technoproject' ),
        'items_list'                 => __( 'Lista de habilidades', 'technoproject' ),
        'items_list_navigation'      => __( 'Navegación de lista de habilidades', 'technoproject' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false, // Tags are not hierarchical
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,  // Often true for tags
        'show_in_rest'               => true,  // Expose this taxonomy in the REST API
        'rest_base'                  => 'skill-tags',
        'rest_controller_class'      => 'WP_REST_Terms_Controller',
        'rewrite'                    => array( 'slug' => 'cursos/habilidad', 'with_front' => false ),
    );
    register_taxonomy( 'skill_tag', array( 'course' ), $args ); // Associate with 'course' CPT
}
// The hook add_action( 'init', 'technoproject_register_skill_tag_taxonomy' );
// will be added to functions.php
