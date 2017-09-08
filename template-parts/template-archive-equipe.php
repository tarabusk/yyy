<?php
/**
 * The template used for displaying projects content on the "projet" CPT archive and on the "cat_projet" taxonomy pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package toa
 */
?>
	<header class="page-header">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
						<h1 class="page-title">
						<?php 

							/**
							 * PAGE TITLE
							 */
							
							$team_title = get_option('options_equipe_trombi');

							if ( isset($team_title) && !empty($team_title) ) :

								// Properly escaping the contributed content.

								echo wp_kses( 
									$team_title,
								
									// Only allow <br /> tags
									array(
										'br' => array()
									)
								);

							else :

								the_archive_title();

							endif;

						?>
						</h1>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="page-content toa-team">

		<?php /* Start the Loop */ ?>
		<?php 

		/**
		 * ASSOCIATES
		 */

		global $wp_query;

		$args = array_merge( $wp_query->query_vars, array(
				'meta_key' => 'equipe_partner_associate',
				'meta_query' => array(
					array(
						'key'     => 'equipe_partner_associate',
						'value'   => '1',
						'compare' => '=',
					)
				)
			)
		);

		$associates = query_posts( $args );

		if (have_posts()) :

		?>
		<div class="rm-grid-container">
			<h2 class="toa-font-alpha">
				Les associés
			</h2>
		</div>
		<div class="toa-layout-theta">
			<div class="toa-layout-theta_content">
			<?php

				while (have_posts()) : the_post();

					// Get the ID
					$associate_ID = get_the_ID();

			    	// Storing the posts ID in an array to avoid printing them twice
			    	// in the next query.
			    	$associates_ID[] = $associate_ID;

					// Get the associate's title
					$associate_position = esc_html(get_post_meta($associate_ID, 'equipe_partner_position', true));

					// Get the associate's city
					$associate_city = esc_html(get_post_meta($associate_ID, 'equipe_partner_city', true));

			?>
				<article id="post-<?php the_ID(); ?>" class="toa-layout-theta_col toa-team-associate js-clickbox">
					<?php if ( has_post_thumbnail() ) : ?>
					<p class="toa-team_asset"><?php the_post_thumbnail( 'associates', array('alt' => '', 'title' => '' ) ); ?></p>
					<?php endif; ?>
					<div class="toa-layout-theta_col-in">
						<div class="toa-team_header">
							<h3 class="toa-team_header-title toa-font-alpha">
								<a href="<?php the_permalink(); ?>" class="js-clickbox_target">
									<?php the_title(); ?>
								</a>
							</h3>
							<?php if (isset($associate_position) || isset($associate_city) && !empty($associate_position) || !empty($associate_city)) : ?>
							<p>
								<?php if (isset($associate_position) && !empty($associate_position)) : echo $associate_position; endif; ?>
								<?php if (isset($associate_position) && isset($associate_city) && !empty($associate_position) && !empty($associate_city)) : echo "/ "; endif; ?>
								<?php if (isset($associate_city) && !empty($associate_city)) : echo $associate_city; endif; ?>
							</p>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php

			    endwhile;

			?>
			</div>
		</div>
		<?php

		endif;

		// After using query_posts, it's safe to reset the query
		wp_reset_query();


	

		/**
		 * PARTNERS (not associates)
		 */

		$args = array_merge( $wp_query->query_vars, array(
				'post__not_in' => $associates_ID
			)
		);

		$not_associates = query_posts( $args );

		if (have_posts()) :

		    while (have_posts()) : the_post();


				// Getting all the existing values for the `equipe_partner_city` custom field
				$not_associates_cities[] = get_post_meta( get_the_ID(), 'equipe_partner_city', true);


		    endwhile;


		    // Make values unique
		    $not_associates_cities = array_unique($not_associates_cities);


			// Sort values alphabetically
			sort($not_associates_cities, SORT_STRING);


		    // Loop through cities, and gather partners by city
		    foreach ($not_associates_cities as $city) :


		    	// Stocking the main query in a temp variable
				$temp_query = $wp_query;

				$args = array_merge( $wp_query->query_vars, array(
						'meta_key' => 'equipe_partner_city',
						'meta_query' => array(
							array(
								'key'     => 'equipe_partner_city',
								'value'   => $city,
								'compare' => '=',
							)
						)
					)
				);

				$not_associates_by_cities = query_posts( $args );

				if ( have_posts() ) :

		?>
		<div class="rm-grid-container toa-section">
			<h2 class="toa-font-alpha">
				<span class="rm-visually-hidden">Collaborateurs situés à </span><?php echo $city; ?>
			</h2>
			<div class="toa-layout-zeta">
				<div class="toa-layout-zeta_content">
					<?php

						while ( have_posts() ) : the_post();


							// Get the ID
							$partner_ID = get_the_ID();


					    	// Get the partner's title
							$partner_position = esc_html(get_post_meta($partner_ID, 'equipe_partner_position', true));


					?>
					<article id="post-<?php the_ID(); ?>" class="toa-layout-zeta_col toa-team-partner">
						<?php if ( has_post_thumbnail() ) : ?>
						<p class="toa-team_asset"><?php the_post_thumbnail( 'medium', array('alt' => '', 'title' => '' ) ); ?></p>
						<?php endif; ?>
						<div class="toa-team_header">
							<h3 class="toa-team_header-title toa-font-alpha">
								<?php the_title(); ?>
							</h3>
							<?php if (isset($partner_position) && !empty($partner_position)) : ?>
							<p class="toa-txt-beta">
								<?php echo $partner_position; ?>
							</p>
							<?php endif; ?>
						</div>
						<div class="toa-team_content">
							<?php the_content(); ?>
						</div>
					</article>
					<?php

						endwhile;

					?>
				</div>
			</div>
		</div>
		<?php

				endif;

				// Get back to the regular main query 
				$wp_query = $temp_query;

		    endforeach;

		endif;

		// After using query_posts, it's safe to reset the query
		wp_reset_query();



		/**
		 * GONE PARTNERS
		 */	

		$acf_gone_partners_title 	= get_option('options_equipe_gone_title');
		$acf_gone_partners 			= get_option('options_equipe_gone');

		if( isset($acf_gone_partners_title) && isset($acf_gone_partners) && !empty($acf_gone_partners) && !empty($acf_gone_partners) ) :

		?>
		<div class="rm-grid-container toa-section">
			<h2 class="toa-font-alpha">
				<?php echo esc_html($acf_gone_partners_title); ?>
			</h2>
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
						<?php echo wpautop(esc_html($acf_gone_partners)); ?>
					</div>
				</div>
			</div>
		</div>
		<?php

		endif;

		?>

</div>