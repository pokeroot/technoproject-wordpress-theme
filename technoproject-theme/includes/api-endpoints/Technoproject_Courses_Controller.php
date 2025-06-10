<?php
/**
 * REST API Courses Controller
 *
 * @package Technoproject
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Technoproject_Courses_Controller extends WP_REST_Controller {

    protected $namespace = 'technoproject/v1';
    protected $rest_base = 'courses';
    protected $post_type;

    public function __construct() {
        parent::__construct(); // Ensure parent constructor is called
        $this->post_type = 'course';
    }

    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            array(
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_items' ),
                    'permission_callback' => array( $this, 'get_items_permissions_check' ),
                    'args'                => $this->get_collection_params(),
                ),
                // Placeholder for future CREATABLE route
                'schema' => array( $this, 'get_public_item_schema' ),
            )
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            array(
                'args' => array(
                    'id' => array(
                        'description' => __( 'Unique identifier for the course.', 'technoproject' ),
                        'type'        => 'integer',
                        'required'    => true,
                    ),
                ),
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_item' ),
                    'permission_callback' => array( $this, 'get_item_permissions_check' ),
                    'args'                => $this->get_context_param( array( 'default' => 'view' ) ),
                ),
                // Placeholder for future EDITABLE/DELETABLE routes
                'schema' => array( $this, 'get_public_item_schema' ),
            )
        );
    }

    public function get_item_permissions_check( $request ) {
        // For now, allow public access. Could be enhanced.
        return true;
    }

    public function get_items_permissions_check( $request ) {
        // For now, allow public access to view courses.
        return true;
    }

    public function get_item( $request ) {
        $id = (int) $request['id'];
        $post = get_post( $id );

        if ( empty( $post ) || $post->post_type !== $this->post_type ) {
            return new WP_Error( 'rest_post_invalid_id', __( 'Invalid course ID.', 'technoproject' ), array( 'status' => 404 ) );
        }

        // Basic check if post is published or user can edit (more granular checks in permission_callback)
        if ( 'publish' !== $post->post_status && ! current_user_can( 'edit_post', $id ) ) {
           return new WP_Error( 'rest_forbidden_context', __( 'Sorry, you are not allowed to view this course.', 'technoproject' ), array( 'status' => rest_authorization_required_code() ) );
        }

        $data = $this->prepare_item_for_response( $post, $request );
        $response = rest_ensure_response( $data );
        return $response;
    }

    public function get_items( $request ) {
        $args = array(
            'post_type'      => $this->post_type, // Use $this->post_type
            'post_status'    => 'publish',
            'posts_per_page' => $request->get_param( 'per_page' ),
            'paged'          => $request->get_param( 'page' ),
            'orderby'        => $request->get_param( 'orderby' ),
            'order'          => $request->get_param( 'order' ),
        );

        if ( ! empty( $request->get_param( 'search' ) ) ) {
            $args['s'] = $request->get_param( 'search' );
        }

        // TODO: Implement advanced filtering
        $query = new WP_Query( $args );
        $courses_data = array();

        if ( $query->have_posts() ) {
            foreach ( $query->posts as $post ) {
                $data = $this->prepare_item_for_response( $post, $request );
                $courses_data[] = $this->prepare_response_for_collection( $data );
            }
        }

        $response = rest_ensure_response( $courses_data );
        $total_posts = $query->found_posts;
        $max_pages = $query->max_num_pages;
        $response->header( 'X-WP-Total', (int) $total_posts );
        $response->header( 'X-WP-TotalPages', (int) $max_pages );
        return $response;
    }

    public function prepare_item_for_response( $post, $request ) {
        $schema = $this->get_item_schema(); // Use $this->get_item_schema() for consistency
        $data = array();

        // Standard fields
        if ( $this->is_field_present_in_schema( $schema, 'id') ) $data['id'] = $post->ID;
        if ( $this->is_field_present_in_schema( $schema, 'title') ) $data['title'] = array( 'raw' => $post->post_title, 'rendered' => get_the_title( $post->ID ) );
        if ( $this->is_field_present_in_schema( $schema, 'content') ) $data['content'] = array( 'raw' => $post->post_content, 'rendered' => apply_filters( 'the_content', $post->post_content ) );
        if ( $this->is_field_present_in_schema( $schema, 'excerpt') ) $data['excerpt'] = array( 'raw' => $post->post_excerpt, 'rendered' => get_the_excerpt( $post->ID ) );
        if ( $this->is_field_present_in_schema( $schema, 'slug') ) $data['slug'] = $post->post_name;

        if ( $this->is_field_present_in_schema( $schema, 'date') ) {
            if ( '0000-00-00 00:00:00' === $post->post_date_gmt ) $data['date_gmt'] = null;
            else $data['date_gmt'] = mysql_to_rfc3339( $post->post_date_gmt );
            $data['date'] = mysql_to_rfc3339( $post->post_date );
        }
        if ( $this->is_field_present_in_schema( $schema, 'modified') ) {
            if ( '0000-00-00 00:00:00' === $post->post_modified_gmt ) $data['modified_gmt'] = null;
            else $data['modified_gmt'] = mysql_to_rfc3339( $post->post_modified_gmt );
            $data['modified'] = mysql_to_rfc3339( $post->post_modified );
        }
        if ( $this->is_field_present_in_schema( $schema, 'status') ) $data['status'] = $post->post_status;

        // Custom Metafields
        if ( $this->is_field_present_in_schema( $schema, 'short_description') ) $data['short_description'] = get_post_meta( $post->ID, '_technoproject_short_description', true );
        if ( $this->is_field_present_in_schema( $schema, 'level') ) $data['level'] = get_post_meta( $post->ID, '_technoproject_level', true );
        if ( $this->is_field_present_in_schema( $schema, 'format') ) $data['format'] = get_post_meta( $post->ID, '_technoproject_format', true );

        // Taxonomies
        if ( $this->is_field_present_in_schema( $schema, 'course_categories') ) $data['course_categories'] = $this->get_taxonomy_terms( $post->ID, 'course_category' );
        if ( $this->is_field_present_in_schema( $schema, 'skill_tags') ) $data['skill_tags'] = $this->get_taxonomy_terms( $post->ID, 'skill_tag' );

        // Featured Image
        if ( $this->is_field_present_in_schema( $schema, 'featured_image_url') ) {
            $featured_image_id = get_post_thumbnail_id( $post->ID );
            if ( $featured_image_id ) {
                $image_url_large = wp_get_attachment_image_url( $featured_image_id, 'large' );
                $image_url_full = wp_get_attachment_image_url( $featured_image_id, 'full' );
                $data['featured_image_url'] = $image_url_large ?: $image_url_full;
            } else {
                $data['featured_image_url'] = null;
            }
        }

        $context = ! empty( $request['context'] ) ? $request['context'] : 'view';
        $data    = $this->add_additional_fields_to_object( $data, $request );
        $data    = $this->filter_response_by_context( $data, $context );
        $response = rest_ensure_response( $data );
        $response->add_links( $this->prepare_links( $post ) );
        return $response;
    }

    protected function get_taxonomy_terms( $post_id, $taxonomy ) {
        $terms = get_the_terms( $post_id, $taxonomy );
        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            return array();
        }
        return array_map( function( $term ) {
            return array( 'id' => $term->term_id, 'name' => $term->name, 'slug' => $term->slug );
        }, $terms );
    }

    // Helper to check if a field is defined in the schema properties
    protected function is_field_present_in_schema( $schema, $field_name ) {
        return isset( $schema['properties'][ $field_name ] );
    }

    public function get_item_schema() {
        if ( $this->schema ) {
            // Ensure to return a copy if it might be modified by add_additional_fields_schema
            // return $this->add_additional_fields_schema( $this->schema );
        }
        // Define schema if not already defined or to override
        $schema = array(
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => $this->post_type,
            'type'       => 'object',
            'properties' => array(
                'id' => array( 'description' => __( 'Unique identifier for the object.', 'technoproject' ), 'type' => 'integer', 'context' => array( 'view', 'edit', 'embed' ), 'readonly' => true ),
                'title' => array( 'description' => __( 'The title for the object.', 'technoproject' ), 'type' => 'object', 'context' => array( 'view', 'edit', 'embed' ), 'properties' => array( 'raw' => array( 'description' => __( 'Title for the object, as it exists in the database.', 'technoproject' ), 'type' => 'string', 'context' => array( 'edit' ) ), 'rendered' => array( 'description' => __( 'HTML title for the object, transformed for display.', 'technoproject' ), 'type' => 'string', 'context' => array( 'view', 'edit', 'embed' ), 'readonly' => true ) ) ),
                'content' => array( 'description' => __( 'The content for the object.', 'technoproject' ), 'type' => 'object', 'properties' => array( 'raw' => array( 'description' => __( 'Content for the object, as it exists in the database.', 'technoproject' ), 'type' => 'string', 'context' => array( 'edit' ) ), 'rendered' => array( 'description' => __( 'HTML content for the object, transformed for display.', 'technoproject' ), 'type' => 'string', 'context' => array( 'view', 'edit', 'embed' ), 'readonly' => true ) ) ),
                'excerpt' => array( 'description' => __( 'The excerpt for the object.', 'technoproject' ), 'type' => 'object', 'properties' => array( 'raw' => array( 'description' => __( 'Excerpt for the object, as it exists in the database.', 'technoproject' ), 'type' => 'string', 'context' => array( 'edit' ) ), 'rendered' => array( 'description' => __( 'HTML excerpt for the object, transformed for display.', 'technoproject' ), 'type' => 'string', 'context' => array( 'view', 'edit', 'embed' ), 'readonly' => true ) ) ),
                'slug' => array( 'description' => __( 'An alphanumeric identifier for the object unique to its type.', 'technoproject' ), 'type' => 'string', 'context' => array( 'view', 'edit', 'embed' ) ),
                'date' => array( 'description' => __( "The date the object was published, in the site's timezone.", 'technoproject' ), 'type' => 'string', 'format' => 'date-time', 'context' => array( 'view', 'edit', 'embed' ) ),
                'date_gmt' => array( 'description' => __( 'The date the object was published, as GMT.', 'technoproject' ), 'type' => ['string', 'null'], 'format' => 'date-time', 'context' => array( 'view', 'edit' ) ),
                'modified' => array( 'description' => __( "The date the object was last modified, in the site's timezone.", 'technoproject' ), 'type' => 'string', 'format' => 'date-time', 'context' => array( 'view', 'edit' ) ),
                'modified_gmt' => array( 'description' => __( 'The date the object was last modified, as GMT.', 'technoproject' ), 'type' => ['string', 'null'], 'format' => 'date-time', 'context' => array( 'view', 'edit' ) ),
                'status' => array( 'description' => __( 'A named status for the object.', 'technoproject' ), 'type' => 'string', 'context' => array( 'view', 'edit' ) ),
                'short_description' => array( 'description' => __( 'A short description for the course.', 'technoproject' ), 'type' => 'string', 'context' => array( 'view', 'edit', 'embed' ) ),
                'level' => array( 'description' => __( 'The difficulty level of the course.', 'technoproject' ), 'type' => 'string', 'context' => array( 'view', 'edit', 'embed' ) ),
                'format' => array( 'description' => __( 'The format of the course.', 'technoproject' ), 'type' => 'string', 'context' => array( 'view', 'edit', 'embed' ) ),
                'course_categories' => array( 'description' => __( 'Course categories associated with the course.', 'technoproject' ), 'type' => 'array', 'items' => array( 'type' => 'object', 'properties' => array( 'id' => array( 'type' => 'integer' ), 'name' => array( 'type' => 'string' ), 'slug' => array( 'type' => 'string' ) ) ), 'context' => array( 'view', 'edit', 'embed' ) ),
                'skill_tags' => array( 'description' => __( 'Skill tags associated with the course.', 'technoproject' ), 'type' => 'array', 'items' => array( 'type' => 'object', 'properties' => array( 'id' => array( 'type' => 'integer' ), 'name' => array( 'type' => 'string' ), 'slug' => array( 'type' => 'string' ) ) ), 'context' => array( 'view', 'edit', 'embed' ) ),
                'featured_image_url' => array( 'description' => __( "URL of the course's featured image (large size).", 'technoproject' ), 'type' => ['string', 'null'], 'format' => 'uri', 'context' => array( 'view', 'edit', 'embed' ) ),
            ),
        );
        $this->schema = $schema;
        return $this->add_additional_fields_schema( $this->schema );
    }

    public function get_collection_params() {
        $params = parent::get_collection_params();
        $params['orderby']['default'] = 'date';
        $params['order']['default'] = 'desc';
        // Add other params like 'category', 'level', 'format' from doc 4.2 later
        return $params;
    }

    protected function prepare_links( $post ) {
        $links = array(
            'self' => array( 'href' => rest_url( sprintf( '%s/%s/%d', $this->namespace, $this->rest_base, $post->ID ) ) ),
            'collection' => array( 'href' => rest_url( sprintf( '%s/%s', $this->namespace, $this->rest_base ) ) ),
            // Add other links like author, featured media, terms etc.
        );
        return $links;
    }
}
