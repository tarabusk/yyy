<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package toa
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
						<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
						<?php

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

	<div class="page-content">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col toa-contrib">
						<?php the_content(); ?>
						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'toa' ),
								'after'  => '</div>',
							) );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer class="page-footer">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
						<?php toa_entry_footer(); ?>
					</div>
				</div>
			</div>
		</div>
	</footer>
</article>
