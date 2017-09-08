<?php
/**
 * @package toa
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('toa-sep-post toa-section'); ?>>
	<header class="entry-header">
		<div class="rm-grid-container">
			<div class="toa-layout-delta">

				<div class="toa-layout-delta_col-first">
					<?php the_title( '<h2 class="entry-title"><a href="'. get_the_permalink() .'" rel="bookmark"><span>', '</span></a></h2>' ); ?>
					<?php

						/**
						 * EDIT LINK for admins
						 */
						edit_post_link( __('Edit This'), '<p class="post-edit-link-container">', '</p>' );

					?>
				</div>

				<div class="toa-layout-delta_col-last">
					<div class="entry-meta">
						<?php toa_posted_on(); ?>
						<?php toa_simple_share(); ?>
					</div>
				</div>

			</div>
		</div>

	</header>

	<div class="entry-content">

		<?php 

		/**
		 * POST THUMBNAIL
		 */

		if (has_post_thumbnail()) : 

			$post_thumb_ID 			= get_post_thumbnail_id();

			// Check if the matching 'very-large-picture' image is available. If it's not, do not display any image.
			$very_large_post_thumb 	= image_get_intermediate_size( $post_thumb_ID, 'very-large-picture' );

			// Otherwise check if the fullsize image is big enough to be featured
			$fullwidth_image		= wp_get_attachment_image_src($post_thumb_ID, 'fullsize');
			$fullwidth_image_width	= (int) $fullwidth_image[1];
			$fullwidth_image_height	= (int) $fullwidth_image[2];

			// Get the 'very-large-picture' width and height
			$minimal_width 			= (int) get_image_size('very-large-picture')['width'];
			$minimal_height 		= (int) get_image_size('very-large-picture')['height'];

			if ( $very_large_post_thumb || $fullwidth_image ) :

		?>
		<div class="toa-asset-fullwidth">
			<?php if ( $very_large_post_thumb ) : ?>
			<img src="<?php echo $very_large_post_thumb['url']; ?>" width="<?php echo $very_large_post_thumb['width']; ?>" height="<?php echo $very_large_post_thumb['height']; ?>" alt="" />
			<?php elseif ( $fullwidth_image_width >= $minimal_width && $fullwidth_image_height >= $minimal_height ) : ?>
			<img src="<?php echo $fullwidth_image[0]; ?>" width="<?php echo $fullwidth_image_width; ?>" height="<?php echo $fullwidth_image_height; ?>" alt="" />
			<?php endif; ?>
		</div>
		<?php

			endif;

		endif;

		?> 
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
						<?php 

							/** 
							* EXCERPT
							*/
							$excerpt = get_the_excerpt();
							$excerpt_size = strlen($excerpt);

							// If the excerpt contains less than 120 characters, use a bigger font-size.
							$excerpt_class = 'toa-excerpt';

							if ($excerpt_size < 120) :
								$excerpt_class .= ' toa-excerpt-bigger';
							endif;

							if( !empty($excerpt) ) : 

						?>
						<div class="<?php echo $excerpt_class; ?>">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>
						<p class="toa-more">
							<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
								En voir plus
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

</article>
