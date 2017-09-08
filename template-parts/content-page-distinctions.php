<?php
/**
 * The template used for displaying page content on the “Distinctions” page.
 *
 * @package toa
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
						<?php 

						// Has a custom ACF title be set up?
						$acf_page_title = get_post_meta( get_the_ID(), 'distinctions_title' );

						// If it has, use it instead of the regular page title
						$page_title = ( !empty($acf_page_title) ? $acf_page_title[0] : get_the_title()); // returns true

						echo '<h1 class="entry-title">' . $page_title . '</h1>';

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

	<div class="entry-content toa-distinctions">
		<div class="rm-grid-container">
			<?php 

				/**
				 * QUOTE
				 */
				$acf_distinctions_quote = get_post_meta( get_the_ID(), 'distinctions_quote', true );

				if ( !empty($acf_distinctions_quote) ) :

			?>
			<div class="toa-layout-epsilon toa-section">
				<div class="toa-layout-epsilon_content">
					<div class="toa-layout-epsilon_col toa-contrib">
						<blockquote class="toa-txt-alpha">
							<?php echo wpautop(esc_html($acf_distinctions_quote)); ?>
						</blockquote>
					</div>
				</div>
			</div>
			<?php

				endif;


				/**
				 * INTRODUCTION SENTENCE
				 */
				$acf_intro_sentence = get_post_meta( get_the_ID(), 'distinctions_intro_sentence', true );

				if ( !empty($acf_intro_sentence) ) :

			?>
			<div class="toa-layout-epsilon toa-section">
				<div class="toa-layout-epsilon_content">
					<div class="toa-layout-epsilon_col">
						<p class="toa-font-alpha">
							<?php echo esc_html($acf_intro_sentence); ?>
						</p>
					</div>
				</div>
			</div>
			<?php

				endif;

				/**
				 * DISTINCTIONS
				 */
				$acf_distinctions_awards = get_post_meta( get_the_ID(), 'distinctions_awards', true );

				if ( !empty($acf_distinctions_awards) ) :

			?>
			<div class="toa-layout-zeta">
				<ol class="toa-layout-zeta_content">
			<?php 

					for ( $i = 0; $i < $acf_distinctions_awards; $i++ ) :

						// Get the awards' year
						$acf_distinction_year 	= get_post_meta( get_the_ID(), 'distinctions_awards_' . $i . '_year', true );

						// Get the awards' content
						$acf_distinction_award 	= get_post_meta( get_the_ID(), 'distinctions_awards_' . $i . '_award', true );

						if ( !empty($acf_distinction_year) && !empty($acf_distinction_award) ) :

			?>
					<li class="toa-layout-zeta_col">

						<h2>
							<span class="toa-txt-delta">
								<span class="toa-font-alpha"><?php echo $acf_distinction_year; ?></span>
								<span class="rm-visually-hidden">
								&nbsp;: 
								</span>
							</span>

							<?php echo $acf_distinction_award; ?>
						</h2>

					</li>
			<?php 

					endif;

				endfor;

			?>
				</ol>
			</div>
			<?php

				endif; 

			?>

		</div>
	</div>

		
</article>