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

    /**
     * Namespace for the REST API.
     * @var string
     */
    protected $namespace = 'technoproject/v1';

    /**
     * Rest base for the current object.
     * @var string
     */
    protected $rest_base = 'courses';

    /**
     * Registers the routes for the objects of the controller.
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            array(
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_items' ), // Changed to get_items for WP_REST_Controller convention
                    'permission_callback' => array( $this, 'get_items_permissions_check' ),
                    'args'                => $this->get_collection_params(),
                ),
                // Placeholder for future CREATABLE route as per document
                // array(
                // 'methods' => WP_REST_Server::CREATABLE,
                // 'callback' => array( $this, 'create_item' ),
                // 'permission_callback' => array( $this, 'create_item_permissions_check' ),
                // 'args' => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
                // ),
                'schema' => array( $this, 'get_public_item_schema' ), // Define a schema
            )
        );
    }

    /**
     * Checks if a given request has access to get items.
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check( $request ) {
        // For now, allow public access to view courses.
        // Add more granular checks if needed, e.g., based on user roles or capabilities.
        return true;
    }

    /**
     * Retrieves a collection of courses.
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_items( $request ) {
        $args = array(
            'post_type'      => 'course', // Our CPT
            'post_status'    => 'publish',
            'posts_per_page' => $request->get_param( 'per_page' ),
            'paged'          => $request->get_param( 'page' ),
            // Basic order/orderby
            'orderby'        => $request->get_param( 'orderby' ),
            'order'          => $request->get_param( 'order' ),
        );

        // Basic search capability
        if ( ! empty( $request->get_param( 'search' ) ) ) {
            $args['s'] = $request->get_param( 'search' );
        }

        // TODO: Implement advanced filtering based on taxonomies (course_category, skill_tag)
        // and meta fields (level, format, price, dates etc.) as per document section 4.2

        $query = new WP_Query( $args );
        $courses_data = array();

        if ( $query->have_posts() ) {
            foreach ( $query->posts as $post ) {
                $data = $this->prepare_item_for_response( $post, $request );
                $courses_data[] = $this->prepare_response_for_collection( $data );
            }
        }

        $response = rest_ensure_response( $courses_data );

        // Set pagination headers
        $total_posts = $query->found_posts;
        $max_pages = $query->max_num_pages;
        $response->header( 'X-WP-Total', (int) $total_posts );
        $response->header( 'X-WP-TotalPages', (int) $max_pages );

        return $response;
    }

    /**
     * Prepares a single course output for response.
     * This is where you would fetch and structure all course data.
     *
     * @param WP_Post         $post    Post object.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response( $post, $request ) {
        // This is a simplified representation.
        // The full implementation should match the detailed response structure
        // from section 7.2 of the architecture document.
        $schema = $this->get_item_schema();
        $data = array();

        if ( ! empty( $schema['properties']['id'] ) ) {
            $data['id'] = $post->ID;
        }
        if ( ! empty( $schema['properties']['title'] ) ) {
            $data['title'] = array(
                'raw' => $post->post_title,
                'rendered' => get_the_title( $post->ID )
            );
        }
        if ( ! empty( $schema['properties']['content'] ) ) {
             $data['content'] = array(
                 'raw' => $post->post_content,
                 'rendered' => apply_filters( 'the_content', $post->post_content )
             );
        }
        if ( ! empty( $schema['properties']['excerpt'] ) ) {
             $data['excerpt'] = array(
                 'raw' => $post->post_excerpt,
                 'rendered' => get_the_excerpt( $post->ID ) // Or apply_filters if needed
             );
        }
        if ( ! empty( $schema['properties']['slug'] ) ) {
            $data['slug'] = $post->post_name;
        }
        if ( ! empty( $schema['properties']['date'] ) ) {
            $data['date'] = $this->prepare_date_response( $post->post_date_gmt, $post->post_date );
        }
        if ( ! empty( $schema['properties']['modified'] ) ) {
            $data['modified'] = $this->prepare_date_response( $post->post_modified_gmt, $post->post_modified );
        }
         if ( ! empty( $schema['properties']['status'] ) ) {
             $data['status'] = $post->post_status;
         }

        // TODO: Add instructor, format, duration, level, price, rating, thumbnail,
        // gallery, tags, categories, startDate, endDate, capacity, enrolled,
        // sessions, materials, requirements, objectives, certification, etc.
        // by fetching post meta and taxonomy terms.

        // Example for course_category taxonomy
        // $data['course_categories'] = wp_get_post_terms( $post->ID, 'course_category', array( 'fields' => 'ids' ) );

        // Example for a custom field (meta)
        // $data['level'] = get_post_meta( $post->ID, 'course_level', true );


        $context = ! empty( $request['context'] ) ? $request['context'] : 'view';
        $data    = $this->add_additional_fields_to_object( $data, $request );
        $data    = $this->filter_response_by_context( $data, $context );

        // Wrap the data in a response object.
        $response = rest_ensure_response( $data );
        // Add links.
        $response->add_links( $this->prepare_links( $post ) );

        return $response;
    }

    /**
     * Retrieves the course's schema, conforming to JSON Schema.
     * This should be very detailed as per section 7.2 of the architecture document.
     * For now, a simplified version.
     *
     * @return array Item schema data.
     */
     public function get_item_schema() {
         if ( $this->schema ) {
             return $this->add_additional_fields_schema( $this->schema );
         }
         $schema = array(
             '$schema'    => 'http://json-schema.org/draft-04/schema#',
             'title'      => 'course',
             'type'       => 'object',
             'properties' => array(
                 'id'                => array(
                     'description' => __( 'Unique identifier for the object.', 'technoproject' ),
                     'type'        => 'integer',
                     'context'     => array( 'view', 'edit', 'embed' ),
                     'readonly'    => true,
                 ),
                 'title'             => array(
                     'description' => __( 'The title for the object.', 'technoproject' ),
                     'type'        => 'object',
                     'context'     => array( 'view', 'edit', 'embed' ),
                     'properties'  => array(
                         'raw' => array(
                             'description' => __( 'Title for the object, as it exists in the database.', 'technoproject' ),
                             'type' => 'string',
                             'context' => array( 'edit' ),
                         ),
                         'rendered' => array(
                             'description' => __( 'HTML title for the object, transformed for display.', 'technoproject' ),
                             'type' => 'string',
                             'context' => array( 'view', 'edit', 'embed' ),
                             'readonly' => true,
                         ),
                     ),
                 ),
                 // Simplified for now, many more fields to add from doc 7.2
                 // instructor, format, duration, level, price, rating, thumbnail, etc.
                 // content, excerpt, slug, date, modified, status also added above for basic functionality
                 'content'           => array(
                    'description' => __( 'The content for the object.', 'technoproject' ),
                    'type'        => 'object',
                    // Omitting other properties for brevity, similar to title
                 ),
                 'excerpt'           => array(
                    'description' => __( 'The excerpt for the object.', 'technoproject' ),
                    'type'        => 'object',
                    // Omitting other properties for brevity
                 ),
                 'slug'              => array(
                    'description' => __( 'An alphanumeric identifier for the object unique to its type.', 'technoproject' ),
                    'type'        => 'string',
                    'context'     => array( 'view', 'edit', 'embed' ),
                 ),
                 'date'              => array(
                    'description' => __( "The date the object was published, in the site's timezone.", 'technoproject' ),
                    'type'        => 'string',
                    'format'      => 'date-time',
                    'context'     => array( 'view', 'edit', 'embed' ),
                 ),
                 'modified'          => array(
                    'description' => __( "The date the object was last modified, in the site's timezone.", 'technoproject' ),
                    'type'        => 'string',
                    'format'      => 'date-time',
                    'context'     => array( 'view', 'edit' ),
                    'readonly'    => true,
                 ),
                 'status'            => array(
                    'description' => __( 'A named status for the object.', 'technoproject' ),
                    'type'        => 'string',
                    'context'     => array( 'view', 'edit' ),
                 ),
             ),
         );
         $this->schema = $schema;
         return $this->add_additional_fields_schema( $this->schema );
     }

    /**
     * Retrieves the query parameters for collections.
     *
     * @return array Collection parameters.
     */
    public function get_collection_params() {
        $params = parent::get_collection_params();
        $params['orderby']['default'] = 'date';
        $params['order']['default'] = 'desc';
        // Add other params like 'category', 'level', 'format' from doc 4.2 later
        return $params;
    }

     /**
      * Prepares links for the request.
      *
      * @param WP_Post $post Post object.
      * @return array Links for the given post.
      */
     protected function prepare_links( $post ) {
         $links = array(
             'self' => array(
                 'href' => rest_url( sprintf( '%s/%s/%d', $this->namespace, $this->rest_base, $post->ID ) ),
             ),
             'collection' => array(
                 'href' => rest_url( sprintf( '%s/%s', $this->namespace, $this->rest_base ) ),
             ),
             // Add other links like author, featured media, terms etc.
         );
         return $links;
     }
}
