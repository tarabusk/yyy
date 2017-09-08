<?php
/**
 * The template used for displaying "equipe" single posts
 *
 * @package toa
 */

// Get the current post's ID 
$current_post_ID = get_the_ID();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('toa-sep-post toa-section'); ?>>
	<header class="entry-header">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">

					<div class="toa-layout-alpha_col">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<?php 

						// Get the associate's title
						$associate_position = esc_html(get_post_meta($current_post_ID, 'equipe_partner_position', true));

						// Get the associate's city
						$associate_city = esc_html(get_post_meta($current_post_ID, 'equipe_partner_city', true));

						if (isset($associate_position) || isset($associate_city) && !empty($associate_position) || !empty($associate_city)) :
							?>
						<p class="toa-txt-beta">
							<?php if (isset($associate_position) && !empty($associate_position)) : echo $associate_position; endif; ?>
							<?php if (isset($associate_position) && isset($associate_city) && !empty($associate_position) && !empty($associate_city)) : echo "/ "; endif; ?>
							<?php if (isset($associate_city) && !empty($associate_city)) : echo $associate_city; endif; ?>
						</p>
						<?php 

						endif;

						/**
						 * EDIT LINK for admins
						 */
						edit_post_link( __('Edit This'), '<p class="post-edit-link-container">', '</p>' );

						?>
					</div>

				</div>
			</div>
		</div>

	</header>

	<div class="entry-content">


		<?php 

			/**
			 * CONTENT
			 */

		?>
		<div class="rm-grid-container toa-section">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>


		<?php 

		/**
		 * GALLERY
		 */

		// Retrieve the pictures' IDs
		$associate_gallery = get_post_meta( $current_post_ID, 'equipe_partner_gallery', true );

		// Check if acf/custom field data exists
		if( isset($associate_gallery) && !empty($associate_gallery)  ) :

			// Prepare the gallery shortcode
			$gallery_shortcode = '[gallery columns="2" ids="'. implode(',', $associate_gallery) . '" size="gallery" link="none"]';

			// Echo gallery
			echo do_shortcode( $gallery_shortcode );

		endif;



		/**
		 * INSIGHTS
		 */

		// Most proud of
		$associate_proud 		= get_post_meta( $current_post_ID, 'equipe_partner_most_proud', true );

		// Highlight
		$associate_highlight 	= get_post_meta( $current_post_ID, 'equipe_partner_highlight', true );

		// Vision
		$associate_vision 		= get_post_meta( $current_post_ID, 'equipe_partner_vision', true );


		if (isset($associate_proud) && !empty($associate_proud) || 
			isset($associate_highlight) && !empty($associate_highlight) ||
			isset($associate_vision) && !empty($associate_vision) ) :

		?>
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col toa-contrib">
						<?php 

						/**
						 * PROUD OF
						 */

						if (isset($associate_proud) && !empty($associate_proud) ) : 

							echo '<h2>Une fierté ?</h2>'."\n";

							$associate_proud = wp_kses( 
								$associate_proud,
							
								// Only allow <a>, <abbr>, <strong>, <b>, <i> and <em> tags
								array(
									'a' => array(
								  		// Here, we whitelist 'href' and 'title' attributes - nothing else allowed!
								  		'href' => array(),
								  		'title' => array()
									),
									'abbr' => array(
								  		// Here, we whitelist the 'title' for better a11y
								  		'title' => array()
									),
									'br' => array(),
									'em' => array(),
									'i' => array(),
									'strong' => array(),
									'b' => array(),
									'p' => array(),
									'ul' => array(),
									'ol' => array(),
									'li' => array()
								)
							);

							echo wpautop($associate_proud);
						
						endif; 


						/**
						 * HIGHLIGHT
						 */

						if (isset($associate_highlight) && !empty($associate_highlight) ) : 

							echo '<h2>Un projet marquant ?</h2>'."\n";

							$associate_highlight = wp_kses( 
								$associate_highlight,
							
								// Only allow <a>, <abbr>, <strong>, <b>, <i> and <em> tags
								array(
									'a' => array(
								  		// Here, we whitelist 'href' and 'title' attributes - nothing else allowed!
								  		'href' => array(),
								  		'title' => array()
									),
									'abbr' => array(
								  		// Here, we whitelist the 'title' for better a11y
								  		'title' => array()
									),
									'br' => array(),
									'em' => array(),
									'i' => array(),
									'strong' => array(),
									'b' => array(),
									'p' => array(),
									'ul' => array(),
									'ol' => array(),
									'li' => array()
								)
							);

							echo $associate_highlight;
						
						endif; 


						/**
						 * VISION
						 */

						if (isset($associate_vision) && !empty($associate_vision) ) : 

							echo '<h2>Pour vous, l’architecture est…</h2>'."\n";

							$associate_vision = wp_kses( 
								$associate_vision,
							
								// Only allow <a>, <abbr>, <strong>, <b>, <i> and <em> tags
								array(
									'a' => array(
								  		// Here, we whitelist 'href' and 'title' attributes - nothing else allowed!
								  		'href' => array(),
								  		'title' => array()
									),
									'abbr' => array(
								  		// Here, we whitelist the 'title' for better a11y
								  		'title' => array()
									),
									'br' => array(),
									'em' => array(),
									'i' => array(),
									'strong' => array(),
									'b' => array(),
									'p' => array(),
									'ul' => array(),
									'ol' => array(),
									'li' => array()
								)
							);

							echo wpautop($associate_vision);
						
						endif; 

						?>
					</div>
				</div>
			</div>
		</div>
		<?php 

		endif; 

		?>
	</div>
</article>


<?php

/**
 * OTHER ASSOCIATES
 */

// Setting up the loop
$args = array(

	// Only display team members
	'post_type' 		=> 'equipe',

	// Display all similar posts with no limit of time
	'posts_per_page' 	=> -1,

	// Exclude the current post
	'post__not_in' 		=> array($current_post_ID),

	// Only display posts that are featured
	'meta_query' 		=> array(
		array(
			'key'     	=> 'equipe_partner_associate',
			'value'   	=> '1',
			'compare' 	=> '=',
		),
	),

	// Order the posts according to the Simple Page Ordering plugin
	'orderby' 			=> 'menu_order',
	'order' 			=> 'ASC'
);

// The loop
$other_associates = null;
$other_associates = new WP_Query( $args );


// Print something only if the loop as something to offer.
if ( $other_associates->have_posts() ) :

?>
<aside>
	<div class="rm-grid-container toa-section">
		<div class="toa-sep-top">
			<h2 class="toa-font-alpha">
				Découvrir les autres associés
			</h2>
			<div class="toa-layout-zeta">
				<ul class="toa-layout-zeta_content">
					<?php 

					while ( $other_associates->have_posts() ) : $other_associates->the_post();  

						// Get the ID
						$associate_ID = get_the_ID();

						// Get the associate's title
						$associate_position = esc_html(get_post_meta($associate_ID, 'equipe_partner_position', true));

						// Get the associate's city
						$associate_city = esc_html(get_post_meta($associate_ID, 'equipe_partner_city', true));

					?>
					<li id="post-<?php the_ID(); ?>" class="toa-layout-zeta_col toa-team-partner js-clickbox">
						<?php if ( has_post_thumbnail() ) : ?>
						<p class="toa-team_asset"><?php the_post_thumbnail( 'medium', array('alt' => '', 'title' => '' ) ); ?></p>
						<?php endif; ?>
						<div class="toa-team_header">
							<h3 class="toa-team_header-title toa-font-alpha">
								<a href="<?php the_permalink(); ?>" class="js-clickbox_target">
									<?php the_title(); ?>
								</a>
							</h3>
							<?php if (isset($associate_position) || isset($associate_city) && !empty($associate_position) || !empty($associate_city)) : ?>
							<p class="toa-txt-beta">
								<?php if (isset($associate_position) && !empty($associate_position)) : echo $associate_position; endif; ?>
								<?php if (isset($associate_position) && isset($associate_city) && !empty($associate_position) && !empty($associate_city)) : echo "/ "; endif; ?>
								<?php if (isset($associate_city) && !empty($associate_city)) : echo $associate_city; endif; ?>
							</p>
							<?php endif; ?>
						</div>
					</li>
					<?php endwhile; ?>
				</ul>
			</div>
		</div>
	</div>
</aside>
<?php

endif;

?>