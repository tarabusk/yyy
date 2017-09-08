<?php
/**
 * The template used for displaying job offers content on the "recrutement" CPT archive pages.
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
							
							$recrutement_title = get_option('options_recrutement_archive_title');

							if ( isset($recrutement_title) && !empty($recrutement_title) ) :

								// Properly escaping the contributed content.

								echo wp_kses( 
									$recrutement_title,
								
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


	<div class="page-content toa-jobs toa-jobs-list">

		<?php 

		/*
		 * ARCHIVE IMAGE
		 */

		$attachment_id = get_option( 'options_recrutement_picture' );

		$default_attr = array(
			'alt'   => trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) )),
		);

		$recrutement_picture = wp_get_attachment_image( get_option( 'options_recrutement_picture' ), 'recrutement', false, $default_attr );

		if( $recrutement_picture ) :
			
			echo '<div class="toa-asset-fullwidth">'. $recrutement_picture .'</div>';

		endif;

		?>

		<div class="rm-grid-container">

			<?php if ( have_posts() ) : ?>
			<div class="toa-layout-beta toa-jobs-list">
				<ul class="toa-layout-beta_content">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<li class="toa-layout-beta_col toa-jobs-list_item">

						<h2 class="toa-txt-delta toa-jobs-list_title toa-font-alpha">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>

						<?php the_excerpt(); ?>

					</li>

				<?php endwhile; ?>
				</ul>
			</div>
			<?php

			else : 

				get_template_part( 'template-parts/content', 'none' );

			endif;
				
			?>
		</div>

		<?php 

		/*
		 * SPECULATIVE APPLICATION
		 */

		$acf_job_emails = get_option('options_recrutement_email');

		if( $acf_job_emails ) :

			$acf_job_emails_mailto = [];

				for ( $i = 0; $i < $acf_job_emails; $i++ ) :

				// Get each email address
				$acf_job_email 	= antispambot(get_option( 'options_recrutement_email_' . $i . '_email_address' ));
				$acf_job_emails_mailto[] = $acf_job_email;

			endfor;

			$acf_job_emails_mailto = implode(';', $acf_job_emails_mailto);

			if ( !empty($acf_job_emails_mailto) ) :

		?>
		<div class="rm-grid-container toa-section">
			<p class="toa-txt-beta toa-font-alpha">
				<a href="mailto:<?php echo $acf_job_emails_mailto; ?>">
					Envoyer une candidature spontanée
				</a>
			</p>
		</div>
		<?php endif; endif; ?>

	</div>

</div>