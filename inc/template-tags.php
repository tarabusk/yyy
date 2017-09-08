<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package toa
 */

if ( ! function_exists( 'toa_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function toa_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="toa-posts-navigation toa-section" role="navigation">
		<div class="rm-grid-container">
			<h2 class="screen-reader-text">
				Navigation entre les pages
			</h2>
			<div class="toa-posts-navigation_links">

				<?php if ( get_next_posts_link() ) : ?>
				<div class="toa-nav-previous">
					<?php next_posts_link( esc_html__( 'Articles plus anciens' ) ); ?>
				</div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="toa-nav-next">
					<?php previous_posts_link( esc_html__( 'Articles plus récents' ) ); ?>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'toa_posts_pagination' ) ) :
/**
 * Display navigation pagination to next/previous set of posts when applicable.
 */
function toa_posts_pagination() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="toa-posts-pagination toa-section" role="navigation">
		<div class="rm-grid-container">
			<h2 class="screen-reader-text">
				Navigation entre les pages
			</h2>
			<div class="toa-posts-pagination_links">

				<?php 

					$prefix = 'Page ';

					$archive_args = array(
						// 'end_size'           => 1,
						// 'mid_size'           => 2,
						'prev_next'          	=> True,
						'prev_text'          	=> '«',
						'next_text'          	=> '»',
						'type'               	=> 'list',
						'before_page_number' 	=> '<span class="rm-visually-hidden">'.$prefix.' </span><span class="toa-pagination-item">',
						'after_page_number' 	=> '</span>'
					);

					$pagination_items = paginate_links( $archive_args );

					// Change 1, 2, 3, 4 etc. to 01, 02, 03, 04 etc.
					for ($i = 1; $i < 10; $i++) {
						$pagination_items = str_replace('<span class="toa-pagination-item">'.$i.'</span>', '<span class="toa-pagination-item">0'.$i.'</span>', $pagination_items);
					}
					//

					echo $pagination_items;
				
				?>

			</div>
		</div>
	</nav>
	<?php
}
endif;


if ( ! function_exists( 'rm_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function rm_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="toa-posts-navigation toa-section" role="navigation">
		<div class="rm-grid-container">
			<h2 class="screen-reader-text">
				Navigation entre les articles
			</h2>
			<div class="toa-posts-navigation_links">
				<?php
					previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
					next_post_link( '<div class="nav-next">%link</div>', '%title' );
				?>
			</div>
		</div>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'toa_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function toa_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		//$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	// $time_string = sprintf( $time_string,
	// 	esc_attr( get_the_date( 'c' ) ),
	// 	esc_html( get_the_date() ),
	// 	esc_attr( get_the_modified_date( 'c' ) ),
	// 	esc_html( get_the_modified_date() )
	// );

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'd/m/Y' ) )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'toa' ),
		//'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		$time_string
	);

	// $byline = sprintf(
	// 	esc_html_x( 'by %s', 'post author', 'toa' ),
	// 	'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	// );

	//echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK
	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK

}
endif;

if ( ! function_exists( 'toa_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function toa_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		// $categories_list = get_the_category_list( esc_html__( ', ', 'toa' ) );
		// if ( $categories_list && toa_categorized_blog() ) {
		// 	printf( '<p class="cat-links">' . esc_html__( 'Posted in %1$s', 'toa' ) . '</p>', $categories_list ); // WPCS: XSS OK
		// }

		/* translators: used between list items, there is a space after the comma */
		// $tags_list = get_the_tag_list( '', esc_html__( ', ', 'toa' ) );
		// if ( $tags_list ) {
		// 	printf( '<p class="tags-links">' . esc_html__( 'Tagged %1$s', 'toa' ) . '</p>', $tags_list ); // WPCS: XSS OK
		// }
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<p class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'toa' ), esc_html__( '1 Comment', 'toa' ), esc_html__( '% Comments', 'toa' ) );
		echo '</p>';
	}

	edit_post_link( __('Edit This'), '<p class="post-edit-link-container">', '</p>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'toa' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'toa' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'toa' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'toa' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'toa' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'toa' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'toa' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'toa' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'toa' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'toa' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'toa' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'toa' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'toa' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'toa' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'toa' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'toa' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'toa' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'toa' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'toa' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'toa' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'toa' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function toa_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'toa_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'toa_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so toa_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so toa_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in toa_categorized_blog.
 */
function toa_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'toa_categories' );
}
add_action( 'edit_category', 'toa_category_transient_flusher' );
add_action( 'save_post',     'toa_category_transient_flusher' );


if ( ! function_exists( 'toa_simple_share' ) ) :
/**
 * Prints simple Twitter and Facebook share links
 */
function toa_simple_share() {

	$simple_share = '<div class="entry-share">'."\n";
	$simple_share .= '<ul>'."\n";
	$simple_share .= '<li><a href="https://twitter.com/home?status=' . get_the_permalink() . '" title="Partager l\'article « '. get_the_title() . ' » sur Twitter"><span class="rm-visually-hidden">Partager sur </span>Twitter</a>'."\n";
	$simple_share .= '<li><a href="https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '" title="Partager l\'article « '. get_the_title() . ' » sur Facebook"><span class="rm-visually-hidden">Partager sur </span>Facebook</a>'."\n";
	$simple_share .= '</ul>';
	$simple_share .= '</div>';

	echo $simple_share;

}
endif;


if ( ! function_exists( 'toa_list_taxonomies_for_cpt' ) ) :
/**
 * Display the terms of a custom taxonomy for a custom post type
 *
 * @param string $cpt Mandatory. The custom post type to retrieve the custom taxonomy from.
 * @param string $taxonomy Mandatory. The custom taxonomy to retrieve for the $cpt custom post type.
 */
function toa_list_taxonomies_for_cpt( $cpt, $taxonomy ) {

	if (!isset($cpt) || !isset($taxonomy) ) return;

	// List child categories
	$customPostTaxonomies = get_object_taxonomies($cpt);

	// Only display results if there are some categories for this CPT
	if(count($customPostTaxonomies) > 0 && in_array($taxonomy, $customPostTaxonomies) ) :

	?>
	<ul class="toa-list-beta">
	<?php 

		foreach($customPostTaxonomies as $tax) :

			// The loop arguments
			if ( is_plugin_active( 'custom-taxonomy-order-ne/customtaxorder.php' ) ) :

				$args = array(

						// This filter comes with the Custom Taxonomy Order NE plugin
						'orderby' => 'term_order',
						//

						'order' => 'ASC',
						'show_count' => 0,
						'pad_counts' => 0,
						'hierarchical' => 0,
						'taxonomy' => $tax,
						'title_li' => ''
					);

			else : 

				$args = array(

						// If the Custom Taxonomy Order NE plugin is not active,
						// use a custom WordPress filter
						'orderby' => 'ID',
						//

						'order' => 'ASC',
						'show_count' => 0,
						'pad_counts' => 0,
						'hierarchical' => 0,
						'taxonomy' => $tax,
						'title_li' => ''
					);

			endif;

			wp_list_categories( $args );

		endforeach;

	?>
	</ul>
	<?php

	endif; 

}
endif;