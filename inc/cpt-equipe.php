<?php
/**
 * Register the 'equipe' custom post type
 */

add_action( 'init', 'rm_register_cpt_equipe' );
function rm_register_cpt_equipe() {
	$labels = array(
		'name' => 'Équipe',
		'singular_name' => 'Équipe',
		'add_new' => 'Ajouter',
		'add_new_item' => 'Ajouter un collaborateur',
		'edit' => 'Éditer',
		'edit_item' => 'Éditer le profil',
		'new_item' => 'Nouveau collaborateur',
		'all_items' => 'Tous les collaborateurs',
		'view' => 'Afficher',
		'view_item' => 'Afficher le profil',
		'search_items' => 'Rechercher un collaborateur',
		'not_found' => 'Aucun collaborateur trouvé',
		'not_found_in_trash' => 'Aucun collaborateur trouvé dans la corbeille',
		'parent' => 'Collaborateur parent',
		'menu_name' => 'Équipe',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'hierarchical' => true,
		//'rewrite' => array( 'slug' => 'equipe/%cat_projet%', 'with_front' => true ),
		'rewrite' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'query_var' => true,
		'menu_position' => 5,
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'has_archive' => 'equipe'

		//'taxonomies' => array( 'category' ),
		// 'description' => '',
		// 'show_in_menu' => true,
		// 'show_in_nav_menus' => true,
		// 'exclude_from_search' => false,
		// 'can_export' => true,
		// 'map_meta_cap' => true,
		// 'yarpp_support' => true
	);

	/* Finally register CPT */
	register_post_type( 'equipe', $args );
}


/**
 * Add this CPT posts to feeds
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-post-types-to-your-main-wordpress-rss-feed/
 */
add_filter('request', 'rm_equipe_addtofeed');
function rm_equipe_addtofeed($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] .= array('equipe');
	return $qv;
}


/**
 * Change post order on the this CPT archive page
 */
add_action('pre_get_posts', 'rm_change_sort_order_equipe', 99); 
function rm_change_sort_order_equipe($query){

	if ( is_admin() || ! $query->is_main_query() )
		return;

	if ( !is_admin() && $query->is_main_query() && is_post_type_archive('equipe') ) :

		// Set the order ASC or DESC
		$query->set( 'order', 'ASC' );

		// Set the orderby
		$query->set( 'orderby', 'menu_order' );

		// Set the number of items to display per page
		// NB: this cause a paging bug, cf. https://core.trac.wordpress.org/ticket/30631
		$query->set( 'posts_per_page', '-1' );

		return;

	endif;    
};