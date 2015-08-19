<?php
/*
Plugin Name: StartUp Portfolio Custom Post Type
Description: Le plugin pour activer le Custom Post Portfolio
Author: Yann Caplain
Version: 0.2.0
*/

//CPT
function startup_reloaded_portfolio() {
	$labels = array(
		'name'                => _x( 'Portfolio items', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Portfolio item', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Portfolio', 'text_domain' ),
		'name_admin_bar'      => __( 'Portfolio', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' )
	);
	$args = array(
		'label'               => __( 'portfolio', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'post-formats' ),
		//'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-art',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
        'capability_type'     => array('portfolio_item','portfolio_items'),
        'map_meta_cap'        => true
	);
	register_post_type( 'portfolio', $args );

}

add_action( 'init', 'startup_reloaded_portfolio', 0 );

// Capabilities

function startup_reloaded_portfolio_caps() {
	$role_admin = get_role( 'administrator' );
	$role_admin->add_cap( 'edit_portfolio_item' );
	$role_admin->add_cap( 'read_portfolio_item' );
	$role_admin->add_cap( 'delete_portfolio_item' );
	$role_admin->add_cap( 'edit_others_portfolio_items' );
	$role_admin->add_cap( 'publish_portfolio_items' );
	$role_admin->add_cap( 'edit_portfolio_items' );
	$role_admin->add_cap( 'read_private_portfolio_items' );
	$role_admin->add_cap( 'delete_portfolio_items' );
	$role_admin->add_cap( 'delete_private_portfolio_items' );
	$role_admin->add_cap( 'delete_published_portfolio_items' );
	$role_admin->add_cap( 'delete_others_portfolio_items' );
	$role_admin->add_cap( 'edit_private_portfolio_items' );
	$role_admin->add_cap( 'edit_published_portfolio_items' );
}

register_activation_hook( __FILE__, 'startup_reloaded_portfolio_caps' );
?>