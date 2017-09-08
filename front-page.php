<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package toa
 */

get_header(); ?>

	<div id="primary" class="content-area toa-content-area">
		<main id="main" class="site-main toa-site-main" role="main">

			<div class="rm-grid-container">
				<?php 

				/**
				 * LATEST NEWS
				 * @author mhguillaumet
				 * @date 2016-04-12
				 */ 
				$args = array(
					'post_type' 		=> 'post',
					'posts_per_page'	=> 1,
					'post__in'  => get_option( 'sticky_posts' ),
    				'ignore_sticky_posts' => 1
				);

				$latest_news_query = new WP_Query( $args );

				if ( $latest_news_query->have_posts() ) :

					// Simple post counter
					$news_counter = 0;
				?>
				<div class="toa-home-news js-clickbox">
					<?php while ( $latest_news_query->have_posts() ) : $latest_news_query->the_post(); ?>
					<div class="toa-home-news_header">
					
						<?php if ($news_counter == 0) : ?>
						<div class="toa-home-news_header-block">
							<h2>Actualités</h2>
						</div>
						<?php endif; ?>

						<div class="toa-home-news_header-block">
							<p><?php the_date('d/m/Y'); ?></p>
						</div>

					</div>
					<div class="toa-home-news_content">
						<h3 class="toa-home-news_title">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h3>
					</div>
					<div class="toa-home-news_footer">
						<!-- <p> -->
							<span class="toa-home-news_link">Lire l'article</span>
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="30px" viewBox="0 0 30 30" style="enable-background:new 0 0 30 30;" xml:space="preserve">
								<path class="st0" d="M15,0C6.8,0,0,6.7,0,15c0,8.2,6.8,15,15,15s15-6.8,15-15C30,6.7,23.2,0,15,0z M18.4,15l-5.8,4
									c-0.2,0.2-0.7,0.2-1,0c-0.3-0.1-0.3-0.4-0.1-0.6l5.5-3.8l-5.5-3.8c-0.2-0.2-0.2-0.4,0.1-0.6c0.3-0.1,0.7-0.1,1,0l5.8,4
									c0.1,0.1,0.2,0.2,0.2,0.3C18.6,14.8,18.5,14.9,18.4,15z"/>
							</svg>
						<!-- </p> -->
					</div>
				<?php 

					$news_counter++;

					endwhile;

				?>
				</div>
				<?php 

				endif;

				wp_reset_query();
				wp_reset_postdata(); 



				/**
				 * LATEST FIVE PROJECTS
				 */ 

				//
				// First, check if the ACF options_homepage_projects field has been set.
				// If it has, then display the projets accordingly.
				//
				
				$homepage_projects_IDs = get_option('options_homepage_projects');

				if( $homepage_projects_IDs ): 

					$i = 0;

					echo '<ol class="toa-home-list js-change-background">'."\n";

					foreach( $homepage_projects_IDs as $post): // variable must be called $post (IMPORTANT)

						if ($i == 0)
						{
							echo '<li class="is-active js-mobile-extend-click">'."\n";
						}
						else 
						{
							echo '<li class="js-mobile-extend-click">'."\n";
						}

						// Retrieve the post ID
						$post_id = get_the_ID();


						// Retrieve the project's background-image
						$size 					= 'homepage';
						$project_background_id 	= get_post_meta( $post_id, 'project_background', true );
						$project_background 	= wp_get_attachment_image_src( $project_background_id, $size )[0];

						if  (isset($project_background) && !empty($project_background) ) : 

							echo '<div class="toa-home-list_asset">'."\n";

							if (function_exists('tevkori_get_srcset_string')) :
							echo '<img src="' . $project_background . '" ' . tevkori_get_srcset_string( $project_background_id, 'homepage' ) . ' alt="" />'; 
							else : 
							echo '<img src="' . $project_background . '" alt="" />'; 
							endif;
							echo '</div>';

						endif;


						// Create the link 
						echo '<a href="'. get_permalink() . '" class="rm-block">';

						// Retrieve the project's catch phrase
						$project_catch_phrase = get_post_meta( $post_id, 'project_catch_phrase', true );

						if (isset($project_catch_phrase) && !empty($project_catch_phrase)) :
							echo '<p class="toa-home-list_title"><span>' . $project_catch_phrase . '</span></p>';
						endif;
						/** */
			
						echo '<h2 class="toa-home-list_subtitle">' . get_the_title() . '</h2>';
						echo '</a>'."\n";


						echo '</li>'."\n";

						$i++;
				
					endforeach;

					echo '</ol>'."\n"; 

				else :


					//
					// If the ACF options_homepage_projects field has not been set,
					// use a regular loop.
					//

					$args = array(
						'post_type'			=> 'projet',
						'posts_per_page'	=> 5,
						'order' 			=> 'ASC',
						'orderby'			=> 'menu_order',

						// Only display posts that are featured
						'meta_query' 		=> array(
							array(
								'key'     	=> 'project_feature',
								'value'   	=> '1',
								'compare' 	=> '=',
							),
						)
					);

					$loop = new WP_Query( $args );
					
					if ( $loop->have_posts() ) : 

						$i = 0;

						echo '<ol class="toa-home-list js-change-background">'."\n";

						while ( $loop->have_posts() ) : $loop->the_post();

							if ($i == 0)
							{
								echo '<li class="is-active js-mobile-extend-click">'."\n";
							}
							else 
							{
								echo '<li class="js-mobile-extend-click">'."\n";
							}

							// Retrieve the post ID
							$post_id = get_the_ID();


							// Retrieve the project's background-image
							$size 					= 'homepage';
							$project_background_id 	= get_post_meta( $post_id, 'project_background', true );
							$project_background 	= wp_get_attachment_image_src( $project_background_id, $size )[0];

							if  (isset($project_background) && !empty($project_background) ) : 

								echo '<div class="toa-home-list_asset">'."\n";

								if (function_exists('tevkori_get_srcset_string')) :
								echo '<img src="' . $project_background . '" ' . tevkori_get_srcset_string( $project_background_id, 'homepage' ) . ' alt="" />'; 
								else : 
								echo '<img src="' . $project_background . '" alt="" />'; 
								endif;
								echo '</div>';

							endif;


							// Create the link 
							echo '<a href="'. get_permalink() . '" class="rm-block">';

							// Retrieve the project's catch phrase
							$project_catch_phrase = get_post_meta( $post_id, 'project_catch_phrase', true );

							if (isset($project_catch_phrase) && !empty($project_catch_phrase)) :
								echo '<p class="toa-home-list_title"><span>' . $project_catch_phrase . '</span></p>';
							endif;
							/** */
				
							echo '<h2 class="toa-home-list_subtitle">' . get_the_title() . '</h2>';
							echo '</a>'."\n";


							echo '</li>'."\n";

							$i++;
					
						endwhile;

						echo '</ol>'."\n"; 

					?>


					<?php

					else :

						//
						// If nothing matches, then returns a 404.
						//

						get_template_part( 'template-parts/content', 'none' );

					endif;

				endif;

				
				// Reset Post Data
				wp_reset_postdata();

				?>
			</div>
				
		</main>
	</div>

<?php get_footer(); ?>
