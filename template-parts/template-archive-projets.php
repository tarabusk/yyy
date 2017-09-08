<?php
/**
 * The template used for displaying projects content on the "projet" CPT archive and on the "cat_projet" taxonomy pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package toa
 */
?>
	<header class="page-header page-header-mini">
		<div class="rm-grid-container">
			<?php

				// Page title (hidden in an accessible way)
				the_archive_title( '<h1 class="page-title rm-visually-hidden">', '</h1>' );

				// List child categories
				echo toa_list_taxonomies_for_cpt('projet', 'cat_projet');

			?>
		</div>
	</header>

	<div class="rm-grid-container">
		<div class="page-content ">
			<div class="toa-projects-layout-alpha">

				<ol class="toa-projects-layout-alpha_content toa-projects-list">

				<?php /* Start the Loop */ ?>
				<?php 

				while ( have_posts() ) : the_post();

					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */

					//$is_project_featured = get_field('project_feature_listing'); 
					$is_project_featured = get_post_meta( get_the_ID(), 'project_feature_listing', true); 

					if ($is_project_featured) :

						get_template_part( 'template-parts/content', 'projet-archive' );

					else : continue;

					endif;

				endwhile; 

				?>
				</ol>
			</div>
		</div>

		<footer class="page-footer">
		<?php 
			// List child categories
			echo toa_list_taxonomies_for_cpt('projet', 'cat_projet');
		?>
		</footer>
	</div>