<?php
/**
 * Register the 'presse' custom post type
 */

add_action( 'init', 'rm_register_cpt_presse' );
function rm_register_cpt_presse() {
	$labels = array(
		'name' => 'Espace presse',
		'singular_name' => 'Espace presse',
		'add_new' => 'Ajouter',
		//'add_new_item' => 'Ajouter un élément presse',
		//'edit' => 'Éditer',
		//'edit_item' => 'Éditer le projet',
		//'new_item' => 'Nouveau projet',
		'all_items' => 'Toutes les publications',
		//'view' => 'Afficher',
		'view_item' => 'Afficher la publication',
		'search_items' => 'Rechercher une publication',
		'not_found' => 'Aucune publication trouvée',
		'not_found_in_trash' => 'Aucune publication trouvée dans la corbeille',
		'parent' => 'Publication parente',
		//'menu_name' => 'Projets',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'espace-presse/%type_presse%', 'with_front' => true ),
		'show_ui' => true,
		'capability_type' => 'post',
		'query_var' => true,
		'menu_position' => 5,
		'supports' => array( 'title', 'thumbnail', 'excerpt' ),
		'exclude_from_search' => true,
		'has_archive' => 'espace-presse'

		//'taxonomies' => array( 'category' ),
		// 'description' => '',
		// 'show_in_menu' => true,
		// 'show_in_nav_menus' => true,
		// 'can_export' => true,
		// 'map_meta_cap' => true,
		// 'yarpp_support' => true
	);


	/* CPT own categories */
	register_taxonomy('type_presse','presse',array(
			'public'                => true,
			'hierarchical'          => true,
			'label'                 => 'Catégories de l\'espace presse',
			'singular_label'        => 'Catégorie de l\'espace presse',
			'query_var'             => true,
			'rewrite'               => true,
			'show_tagcloud'			=> false,
			'rewrite'				=> array('slug' => 'espace-presse' ),
			'show_in_nav_menus'		=> false // We don't want the user to use this taxonomy in wp_nav_menus
		)
	);


	/* Translate Taxonomy Tag */
	function rm_presse_cat_permalink($permalink, $post_id, $leavename) {
	
		if (strpos($permalink, '%type_presse%') === FALSE) return $permalink;
		
		// Get post
		$post = get_post($post_id);
		if (!$post) return $permalink;
		
		// Get taxonomy terms
		$terms = wp_get_object_terms($post->ID, 'type_presse');
		if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
		else $taxonomy_slug = 'no-type';
		return str_replace('%type_presse%', $taxonomy_slug, $permalink);
	}

	add_filter('post_link', 'rm_presse_cat_permalink', 10, 3);
	add_filter('post_type_link', 'rm_presse_cat_permalink', 10, 3);


	/* Finally register CPT */
	register_post_type( 'presse', $args );
	flush_rewrite_rules();
}


/**
 * Redirect the single posts from the 'presse' CPT to the 'presse' archive
 * and also redirect the "Dossiers de presse" custom taxonomy archive to the 'presse' archive to avoid duplicate content
 */
add_action( 'template_redirect', 'rm_redirect_single_cpt' );
function rm_redirect_single_cpt(){ 
    global $post;
    if ( is_singular('presse') || is_tax('type_presse', 'dossiers-de-presse') )
    { 
        wp_redirect( get_post_type_archive_link( 'presse' ) ); exit; 
    }
}


//add_action( 'pre_get_posts', 'rm_presse_archive', 1 );
function rm_presse_archive( $query )
{
	if ( is_admin() || ! $query->is_main_query() )
		return;
	
	if ( is_post_type_archive( 'presse' ) )
	{
		//$query->set( 'posts_per_page', -1 );
		$query->set( 'category_name', 'dossiers-de-presse' );
		return;
	}
}



/**
 * Set post thumbnail programmatically, retrieving an ACF field
 * @link http://support.advancedcustomfields.com/forums/topic/set-image-as-featured-image/
 */
// acf/update_value/name={$field_name} - filter for a specific field based on it's name
add_filter('acf/update_value/name=press_release_picture', 'acf_set_featured_image_presse', 10, 3);
function acf_set_featured_image_presse( $value, $post_id, $field  ){
    
    if($value != ''){
	    //Add the value which is the image ID to the _thumbnail_id meta data for the current post
	    add_post_meta($post_id, '_thumbnail_id', $value);
    }
 
    return $value;
}


/**
 * Change post order on the this CPT archive page
 */
add_action('pre_get_posts', 'rm_change_sort_order_presse'); 
function rm_change_sort_order_presse($query){

	if ( is_admin() || ! $query->is_main_query() )
		return;

	if ( is_post_type_archive('presse') || is_tax( 'type_presse' )  ) :

		// Set the order ASC or DESC
		$query->set( 'order', 'ASC' );

		// Set the orderby
		$query->set( 'orderby', 'menu_order' );

		// Set the number of items to display per page
		// NB: this cause a paging bug, cf. https://core.trac.wordpress.org/ticket/30631
		$query->set( 'posts_per_page', '-1' );


	endif;    

	if ( is_post_type_archive('presse') ) :

		// Only display the "dossiers de presse" category
		$query->set( 'tax_query', array(
									array(
										'taxonomy' => 'type_presse',
										'field'    => 'slug',
										'terms'    => 'dossiers-de-presse',
									)
								)
		);
	
	endif;
}