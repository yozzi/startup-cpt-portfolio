<?php
/*
Plugin Name: StartUp Portfolio
Description: Le plugin pour activer le Custom Post Portfolio
Author: Yann Caplain
Version: 0.5.0
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
		'name'                => _x( 'Portfolio', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'text_domain' ),
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
		'supports'            => array( 'title', 'revisions' ),
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
        //'rewrite' => array('slug' => 'portfolio-items', 'with_front' => true), //Je teste ici le conflict archive/page
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
        'capability_type'     => array('portfolio_item','portfolio_items'),
        'map_meta_cap'        => true
	);
	register_post_type( 'portfolio', $args );

}

add_action( 'init', 'startup_reloaded_portfolio', 0 );

//Flusher les permalink à l'activation du plugin pour qu'ils fonctionnent sans mise à jour manuelle
function startup_reloaded_portfolio_rewrite_flush() {
    startup_reloaded_portfolio();
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'startup_reloaded_portfolio_rewrite_flush' );

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
		'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'startup-cpt-portfolio' ),
		'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'startup-cpt-portfolio' ),
		'menu_name'                  => __( 'Portfolio Categories', 'startup-cpt-portfolio' ),
		'all_items'                  => __( 'All Items', 'startup-cpt-portfolio' ),
		'parent_item'                => __( 'Parent Item', 'startup-cpt-portfolio' ),
		'parent_item_colon'          => __( 'Parent Item:', 'startup-cpt-portfolio' ),
		'new_item_name'              => __( 'New Item Name', 'startup-cpt-portfolio' ),
		'add_new_item'               => __( 'Add New Item', 'startup-cpt-portfolio' ),
		'edit_item'                  => __( 'Edit Item', 'startup-cpt-portfolio' ),
		'update_item'                => __( 'Update Item', 'startup-cpt-portfolio' ),
		'view_item'                  => __( 'View Item', 'startup-cpt-portfolio' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'startup-cpt-portfolio' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'startup-cpt-portfolio' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'startup-cpt-portfolio' ),
		'popular_items'              => __( 'Popular Items', 'startup-cpt-portfolio' ),
		'search_items'               => __( 'Search Items', 'startup-cpt-portfolio' ),
		'not_found'                  => __( 'Not Found', 'startup-cpt-portfolio' )
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

add_action( 'admin_menu' , 'startup_reloaded_portfolio_categories_metabox_remove' );

// Metaboxes
function startup_reloaded_portfolio_meta() {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_startup_reloaded_portfolio_';

	$cmb_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Portfolio item details', 'startup-cpt-portfolio' ),
		'object_types'  => array( 'portfolio' )
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Main picture', 'startup-cpt-portfolio' ),
		'desc' => __( 'Main image of the portfolio item, may be different from the thumbnail. i.e. 3D model', 'startup-cpt-portfolio' ),
		'id'   => $prefix . 'main_pic',
		'type' => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
        ),
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Thumbnail', 'startup-cpt-portfolio' ),
		'desc' => __( 'The portfolio item picture on your website listings, if different from Main picture.', 'startup-cpt-portfolio' ),
		'id'   => $prefix . 'thumbnail',
		'type' => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
        ),
	) );

	$cmb_box->add_field( array(
		'name'       => __( 'Short description', 'startup-cpt-portfolio' ),
		'desc'       => __( 'i.e. "New business building in Montreal"', 'startup-cpt-portfolio' ),
		'id'         => $prefix . 'short',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name'     => __( 'Categoy', 'startup-cpt-portfolio' ),
		'desc'     => __( 'Select the category(ies) of the portfolio item', 'startup-cpt-portfolio' ),
		'id'       => $prefix . 'category',
		'type'     => 'taxonomy_multicheck',
		'taxonomy' => 'portfolio-category', // Taxonomy Slug
		'inline'  => true // Toggles display to inline
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Description', 'startup-cpt-portfolio' ),
		'desc' => __( 'Full, main description', 'startup-cpt-portfolio' ),
		'id'   => $prefix . 'description',
		'type' => 'wysiwyg',
        'options' => array(
            'wpautop' => true, // use wpautop?
            'media_buttons' => false, // show insert/upload button(s)
            'textarea_rows' => get_option('default_post_edit_rows', 5), // rows="..."
            'tabindex' => '',
            'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
            'editor_class' => '', // add extra class(es) to the editor textarea
            'teeny' => false, // output the minimal editor config used in Press This
            'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
            'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
            'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
    ),
	) );
    
    $cmb_box->add_field( array(
		'name'         => __( 'Gallery', 'startup-cpt-portfolio' ),
		'desc'         => __( 'Upload or add multiple images for portfolio item photo gallery.', 'startup-cpt-portfolio' ),
		'id'           => $prefix . 'gallery',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ) // Default: array( 50, 50 )
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Client', 'startup-cpt-portfolio' ),
		'id'         => $prefix . 'client',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'date', 'startup-cpt-portfolio' ),
		'id'         => $prefix . 'date',
		'type'       => 'text_date_timestamp',
        'date_format' => 'm/Y'
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'External url', 'startup-cpt-portfolio' ),
		'desc' => __( 'Link to te portfolio item on an extrenal website.', 'startup-cpt-portfolio' ),
		'id'   => $prefix . 'url',
		'type' => 'text_url'
	) );
}

add_action( 'cmb2_admin_init', 'startup_reloaded_portfolio_meta' );

// Shortcode
add_shortcode( 'portfolio', function( $atts, $content= null ){
    ob_start();
    require get_template_directory() . '/inc/shortcodes/portfolio.php';
    return ob_get_clean();
});
?>