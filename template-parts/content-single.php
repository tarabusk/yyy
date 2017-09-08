<?php
/**
 * @package toa
 */

$post_ID = get_the_ID();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="rm-grid-container">

			<div class="toa-layout-delta">
				<div class="toa-layout-delta_content">
					<div class="toa-layout-delta_col-first">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

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
						</div>
					</div>
				</div>
			</div>

		</div>
	</header>

	<div class="entry-content js-stretch-img-parent">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col toa-contrib js-stretch-img">
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

	<footer class="entry-footer">
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
