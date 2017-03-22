<?php
/**
 * This file registers the Testimonial custom post type.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register Custom Post Type.
 */
function wpstudio_testimonials() {

	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'gts-plugin' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'gts-plugin' ),
		'menu_name'             => __( 'Testimonials', 'gts-plugin' ),
		'name_admin_bar'        => __( 'Post Type', 'gts-plugin' ),
		'archives'              => __( 'Testimonial Archives', 'gts-plugin' ),
		'parent_item_colon'     => __( 'Parent Item:', 'gts-plugin' ),
		'all_items'             => __( 'All Testimonials', 'gts-plugin' ),
		'add_new_item'          => __( 'Add New Testimonial', 'gts-plugin' ),
		'add_new'               => __( 'Add New', 'gts-plugin' ),
		'new_item'              => __( 'New Testimonial', 'gts-plugin' ),
		'edit_item'             => __( 'Edit Testimonial', 'gts-plugin' ),
		'update_item'           => __( 'Update Item', 'gts-plugin' ),
		'view_item'             => __( 'View Testimonial', 'gts-plugin' ),
		'search_items'          => __( 'Search Item', 'gts-plugin' ),
		'not_found'             => __( 'Not found', 'gts-plugin' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'gts-plugin' ),
		'featured_image'        => __( 'Testimonial Image', 'gts-plugin' ),
		'set_featured_image'    => __( 'Set testimonial image', 'gts-plugin' ),
		'remove_featured_image' => __( 'Remove testimonial image', 'gts-plugin' ),
		'use_featured_image'    => __( 'Use as testimonial image', 'gts-plugin' ),
		'insert_into_item'      => __( 'Insert into item', 'gts-plugin' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'gts-plugin' ),
		'items_list'            => __( 'Items list', 'gts-plugin' ),
		'items_list_navigation' => __( 'Items list navigation', 'gts-plugin' ),
		'filter_items_list'     => __( 'Filter items list', 'gts-plugin' ),
	);
	$args = array(
		'public' 				=> true,
		'label'                 => __( 'Testimonial', 'gts-plugin' ),
		'description'           => __( 'Testimonials', 'gts-plugin' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'				=> 'dashicons-format-quote',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => false,
		'capability_type'       => 'page',
		'register_rating'		=> 'add_rating_metabox',
	);
	register_post_type( 'testimonial', $args );
}
add_action( 'init', 'wpstudio_testimonials', 0 );
