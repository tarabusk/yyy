<?php
/**
 * The template used for displaying press releases from the "presse" CPT archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package toa
 */
?>
	<header class="page-header page-header-mini">
		<div class="rm-grid-container">
			<?php 

			/**
			 * PAGE TITLE (hidden in an accessible way)
			 */
			
			echo '<h1 class="page-title rm-visually-hidden">Espace Presse</h1>';

			// List child categories
			echo toa_list_taxonomies_for_cpt('presse', 'type_presse');

			?>
		</div>
	</header>


	<div class="rm-grid-container">
		<div class="page-content<?php if (!is_post_type_archive( 'presse' ) && !is_tax( 'type_presse', 'dossiers-de-presse' ) ) : ?> toa-press-list<?php endif; ?>">

			<?php 


				if ( is_post_type_archive( 'presse' ) || is_tax( 'type_presse', 'dossiers-de-presse' ) ) : 

			?>
			<div class="toa-layout-zeta">
				<div class="toa-layout-zeta_content">
			<?php

					/* Start the Loop */
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', 'dossier-de-presse' );
					endwhile; 

			?>
				</div>
			</div>
			<?php

				else :

					while ( have_posts() ) : the_post();

			?>
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
			<?php
						get_template_part( 'template-parts/content', 'presse' );
			?>
				</div>
			</div>
			<?php

					endwhile;
					
				endif;			

			?>

		</div>
	
		<footer class="page-footer">
			<?php

			// List child categories
			echo toa_list_taxonomies_for_cpt('presse', 'type_presse');

			?>
		</footer>
	</div>

</div>