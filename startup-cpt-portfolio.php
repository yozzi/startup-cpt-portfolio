<?php
/*
Plugin Name: StartUp Portfolio
Description: Le plugin pour activer le Custom Post Portfolio
Author: Yann Caplain
Version: 0.4.0
*/

//Charger traduction
function startup_reloaded_portfolio_translation() {
  load_plugin_textdomain( 'startup-cpt-portfolio', false, dirname( plugin_basename( __FILE__ ) ) ); 
}

add_action( 'plugins_loaded', 'startup_reloaded_portfolio_translation' );

//GitHub Plugin Updater
function startup_reloaded_portfolio_updater() {
	include_once 'lib/updater.php';
	//define( 'WP_GITHUB_FORCE_UPDATE', true );
	if ( is_admin() ) {
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'startup-cpt-portfolio',
			'api_url' => 'https://api.github.com/repos/yozzi/startup-cpt-portfolio',
			'raw_url' => 'https://raw.github.com/yozzi/startup-cpt-portfolio/master',
			'github_url' => 'https://github.com/yozzi/startup-cpt-portfolio',
			'zip_url' => 'https://github.com/yozzi/startup-cpt-portfolio/archive/master.zip',
			'sslverify' => true,
			'requires' => '3.0',
			'tested' => '3.3',
			'readme' => 'README.md',
			'access_token' => '',
		);
		new WP_GitHub_Updater( $config );
	}
}

add_action( 'init', 'startup_reloaded_portfolio_updater' );

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

// Portfolio taxonomy
function startup_reloaded_portfolio_categories() {
	$labels = array(
		'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'startup-reloaded-products' ),
		'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'startup-reloaded-products' ),
		'menu_name'                  => __( 'Portfolio Categories', 'startup-reloaded-products' ),
		'all_items'                  => __( 'All Items', 'startup-reloaded-products' ),
		'parent_item'                => __( 'Parent Item', 'startup-reloaded-products' ),
		'parent_item_colon'          => __( 'Parent Item:', 'startup-reloaded-products' ),
		'new_item_name'              => __( 'New Item Name', 'startup-reloaded-products' ),
		'add_new_item'               => __( 'Add New Item', 'startup-reloaded-products' ),
		'edit_item'                  => __( 'Edit Item', 'startup-reloaded-products' ),
		'update_item'                => __( 'Update Item', 'startup-reloaded-products' ),
		'view_item'                  => __( 'View Item', 'startup-reloaded-products' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'startup-reloaded-products' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'startup-reloaded-products' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'startup-reloaded-products' ),
		'popular_items'              => __( 'Popular Items', 'startup-reloaded-products' ),
		'search_items'               => __( 'Search Items', 'startup-reloaded-products' ),
		'not_found'                  => __( 'Not Found', 'startup-reloaded-products' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false
	);
	register_taxonomy( 'portfolio-category', array( 'portfolio' ), $args );

}

add_action( 'init', 'startup_reloaded_portfolio_categories', 0 );

// Retirer la boite de la taxonomie sur le coté
function startup_reloaded_portfolio_categories_metabox_remove() {
	remove_meta_box( 'tagsdiv-portfolio-category', 'portfolio', 'side' );
    // tagsdiv-product_types pour les taxonomies type tags
    // custom_taxonomy_slugdiv pour les taxonomies type categories
}

//add_action( 'admin_menu' , 'startup_reloaded_portfolio_categories_metabox_remove' );
?>