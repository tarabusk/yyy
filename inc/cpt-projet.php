<?php
/**
 * Register the 'projet' custom post type
 */

add_action( 'init', 'rm_register_cpt_project' );
function rm_register_cpt_project() {
	$labels = array(
		'name' => 'Projets',
		'singular_name' => 'Projet',
		'add_new' => 'Ajouter',
		'add_new_item' => 'Ajouter un projet',
		'edit' => 'Éditer',
		'edit_item' => 'Éditer le projet',
		'new_item' => 'Nouveau projet',
		'all_items' => 'Tous les projets',
		'view' => 'Afficher',
		'view_item' => 'Afficher le projet',
		'search_items' => 'Rechercher un projet',
		'not_found' => 'Aucun projet trouvé',
		'not_found_in_trash' => 'Aucun projet trouvé dans la corbeille',
		'parent' => 'Projet parent',
		'menu_name' => 'Projets',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'projets/%cat_projet%', 'with_front' => true ),
		'show_ui' => true,
		'capability_type' => 'post',
		'query_var' => true,
		'menu_position' => 5,
		'supports' => array( 'title', 'excerpt', 'revisions', 'thumbnail', 'page-attributes' ),
		'has_archive' => 'projets'

		//'taxonomies' => array( 'category' ),
		// 'description' => '',
		// 'show_in_menu' => true,
		// 'show_in_nav_menus' => true,
		// 'exclude_from_search' => false,
		// 'can_export' => true,
		// 'map_meta_cap' => true,
		// 'yarpp_support' => true
	);


	/* CPT own categories */
	register_taxonomy('cat_projet','projet',array(
			'public'                => true,
			'hierarchical'          => true,
			'label'                 => 'Catégories des projets',
			'singular_label'        => 'Catégorie du projet',
			'query_var'             => true,
			'rewrite'               => true,
			'show_tagcloud'			=> false,
			'rewrite'				=> array('slug' => 'projets' ),
			'show_in_nav_menus'		=> false // We don't want the user to use this taxonomy in wp_nav_menus
		)
	);


	/* Translate Taxonomy Tag */
	function rm_projet_type_permalink($permalink, $post_id, $leavename) {
	
		if (strpos($permalink, '%cat_projet%') === FALSE) return $permalink;
		
		// Get post
		$post = get_post($post_id);
		if (!$post) return $permalink;
		
		// Get taxonomy terms
		$terms = wp_get_object_terms($post->ID, 'cat_projet');
		if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
		else $taxonomy_slug = 'no-type';
		return str_replace('%cat_projet%', $taxonomy_slug, $permalink);
	}

	add_filter('post_link', 'rm_projet_type_permalink', 10, 3);
	add_filter('post_type_link', 'rm_projet_type_permalink', 10, 3);


	/* Finally register CPT */
	register_post_type( 'projet', $args );
	flush_rewrite_rules();
}


/**
 * Add this CPT posts to feeds
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-post-types-to-your-main-wordpress-rss-feed/
 */
add_filter('request', 'rm_projet_addtofeed');
function rm_projet_addtofeed($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] .= array('projet');
	return $qv;
}


/**
 * Set post thumbnail programmatically, retrieving an ACF field
 * @link http://support.advancedcustomfields.com/forums/topic/set-image-as-featured-image/
 * acf/update_value/name={$field_name} - filter for a specific field based on it's name
 */
add_filter('acf/update_value/name=project_background', 'acf_set_featured_image_projet', 10, 3);
function acf_set_featured_image_projet( $value, $post_id, $field  ){
    
    if($value != ''){

	    //Add the value which is the image ID to the _thumbnail_id meta data for the current post
	    add_post_meta($post_id, '_thumbnail_id', $value);
    }
 
    return $value;
}

/**
 * Set excerpt programmatically, retrieving an ACF field
 * @link http://support.advancedcustomfields.com/forums/topic/set-image-as-featured-image/
 * acf/update_value/name={$field_name} - filter for a specific field based on it's name
 */
add_filter('acf/update_value/name=project_lead_in', 'acf_set_excerpt', 10, 3);
function acf_set_excerpt( $value, $post_id, $field  ){

	$current_post = get_post( $post_id );
    
    if($value != '' && empty( $current_post->post_excerpt ) ){
	    wp_update_post( array('ID' => $post_id, 'post_excerpt'=> $value) );
    }
 
    return $value;
}


/**
 * Change post order on this CPT archive page
 */
add_action('pre_get_posts', 'rm_change_sort_order_projet'); 
function rm_change_sort_order_projet($query){

	if ( is_admin() || ! $query->is_main_query() )
		return;

	if ( is_post_type_archive('projet') || is_tax('cat_projet') ) :

		// Set the order ASC or DESC
		$query->set( 'order', 'ASC' );

		// Set the orderby
		$query->set( 'orderby', 'menu_order' );

		// Set the number of items to display per page
		$query->set( 'posts_per_page', '-1' );

	endif;    
}