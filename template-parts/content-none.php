<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package toa
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
							<h1 class="page-title">
								Erreur 404
							</h1>
						</div>
					</div>
				</div>
			</div>
		</header>
	</header>

	<div class="page-content">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col toa-contrib">
					<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

						<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'toa' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

					<?php else : ?>

						<?php 

						// Retrieve the site's Contact page
						$contact_page	= get_permalink( get_option( 'options_contact_page' ) );

						?>

						<p class="toa-txt-alpha">
							La page que vous recherchez ne semble pas (ou plus) exister.
						</p>
						<?php if ( isset($contact_page) && !empty($contact_page) ) : ?>
						<p>
							N'hésitez pas à <a href="<?php echo $contact_page; ?>">nous contacter</a> si vous pensez qu'il s'agit d'une erreur.
						</p>
						<?php endif; ?>

					<?php endif; ?>	
					</div>
				</div>
			</div>
		</div>
	</div>

</section>