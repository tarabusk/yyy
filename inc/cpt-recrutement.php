<?php
/**
 * Register the 'recrutement' custom post type
 */

add_action( 'init', 'rm_register_cpt_recrutement' );
function rm_register_cpt_recrutement() {
	$labels = array(
		'name' => 'Recrutement',
		'singular_name' => 'Recrutement',
		'add_new' => 'Ajouter',
		'add_new_item' => 'Ajouter une offre d\'emploi',
		'edit' => 'Éditer',
		'edit_item' => 'Éditer l\'offre d\'emploi',
		'new_item' => 'Nouvelle offre d\'emploi',
		'all_items' => 'Toutes les offres d\'emploi',
		'view' => 'Afficher',
		'view_item' => 'Afficher l\'offre d\'emploi',
		'search_items' => 'Rechercher une offre d\'emploi',
		'not_found' => 'Aucune offre d\'emploi trouvée',
		'not_found_in_trash' => 'Aucune offre d\'emploi trouvée dans la corbeille',
		'parent' => 'Offre parente',
		'menu_name' => 'Recrutement',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'hierarchical' => true,
		//'rewrite' => array( 'slug' => 'recrutement/%cat_projet%', 'with_front' => true ),
		'rewrite' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'query_var' => true,
		'menu_position' => 5,
		'supports' => array( 'title', 'editor', 'excerpt', 'revisions', 'page-attributes' ),
		'has_archive' => 'recrutement'

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
	register_post_type( 'recrutement', $args );
}



/**
 * Add this CPT posts to feeds
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-post-types-to-your-main-wordpress-rss-feed/
 */
add_filter('request', 'rm_recrutement_addtofeed');
function rm_recrutement_addtofeed($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] .= array('recrutement');
	return $qv;
}


/**
 * Change post order on the this CPT archive page
 */
add_action('pre_get_posts', 'rm_change_sort_order_recrutement'); 
function rm_change_sort_order_recrutement($query){

	if ( is_admin() || ! $query->is_main_query() )
		return;

	if ( is_post_type_archive('recrutement') ) :

		// Set the order ASC or DESC
		$query->set( 'order', 'ASC' );

		// Set the orderby
		$query->set( 'orderby', 'menu_order' );

		// Set the number of items to display per page
		// NB: this cause a paging bug, cf. https://core.trac.wordpress.org/ticket/30631
		$query->set( 'posts_per_page', '-1' );

	endif;    
};


/**
 * Edit the excerpt's length
 */

function toa_excerpt_length($length) {

	if ( is_post_type_archive('recrutement') || is_singular('recrutement') ) :
		return 25;
	else :
		return 55;
	endif;
}
add_filter('excerpt_length', 'toa_excerpt_length');

function toa_excerpt_more($more) {
	

	if ( is_post_type_archive('recrutement') || is_singular('recrutement') ) :
		global $post;
		return '…';

	endif;
}
add_filter('excerpt_more', 'toa_excerpt_more');