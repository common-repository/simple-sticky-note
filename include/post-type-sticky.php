<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Sticky Note Post Type
 *
 * @class       Sticky_Note_Post_type
 * @since       1.0
 * @package     Sticky Note
 * @category    Class
 * @author      Shark Themes
 */

class ST_Sticky_Note_Post_type {

    public function __construct() {
        add_action( 'init', array( $this, 'tp_course_post_type' ) );
    }

    public function tp_course_post_type() {

        $sticky_note_labels = array(
            'name'               => _x( 'Sticky Note', 'post type general name', 'st-sticky-note' ),
            'singular_name'      => _x( 'Sticky Note', 'post type singular name', 'st-sticky-note' ),
            'menu_name'          => _x( 'Sticky Note', 'admin menu', 'st-sticky-note' ),
            'name_admin_bar'     => _x( 'Sticky Note', 'add new on admin bar', 'st-sticky-note' ),
            'add_new'            => _x( 'Add New', 'Sticky Note', 'st-sticky-note' ),
            'add_new_item'       => __( 'Add New Sticky Note', 'st-sticky-note' ),
            'new_item'           => __( 'New Sticky Note', 'st-sticky-note' ),
            'edit_item'          => __( 'Edit Sticky Note', 'st-sticky-note' ),
            'view_item'          => __( 'View Sticky Note', 'st-sticky-note' ),
            'all_items'          => __( 'All Sticky Note', 'st-sticky-note' ),
            'search_items'       => __( 'Search Sticky Note', 'st-sticky-note' ),
            'parent_item_colon'  => __( 'Parent Sticky Note:', 'st-sticky-note' ),
            'not_found'          => __( 'No Sticky Note Found.', 'st-sticky-note' ),
            'not_found_in_trash' => __( 'No Sticky Note Found in Trash.', 'st-sticky-note' )
        );
        $sticky_note_args = array(
            'labels'             => $sticky_note_labels,
            'description'        => __( 'Description.', 'st-sticky-note' ),
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => false,
            'show_in_menu'       => false,
            'exclude_from_search' => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-book',
            'supports'           => array( 'title', 'editor', 'author' )
        );
        register_post_type( 'st-sticky-note', $sticky_note_args );
        
    }

}

new ST_Sticky_Note_Post_type();