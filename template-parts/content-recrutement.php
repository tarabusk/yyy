<?php
/**
 * @package toa
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('toa-joboffer'); ?>>
	<header class="entry-header toa-joboffer_header">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col toa-contrib">
						<?php 

							/** 
							 * JOB OFFER'S TITLE
							 */
							the_title( '<h1 class="entry-title toa-txt-gamma">', '</h1>' );

							the_content();

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

	<div class="entry-content toa-joboffer_content">
		<div class="rm-grid-container">
			<div class="toa-layout-alpha">
				<?php 

					/**
					 * PAGE CONTENT
					 */

					$post_id = get_the_ID();
					$flexible_rows = get_post_meta( $post_id, 'recrutement_content', true );

					foreach( $flexible_rows as $count => $flexible_row ) {

						switch( $flexible_row ) {
						
							/**
							 * TITLE + LIST LAYOUT
							 */
							case 'recrutement_layout_title_list':

								// Get the block's title
								$title 		= esc_html( get_post_meta( $post_id, 'recrutement_content_' . $count . '_recrutement_list_title', true ) );

								if ($title)
									echo '<div class="toa-section">'."\n";
									echo '<div class="toa-layout-alpha_content">'."\n";
									echo '<div class="toa-layout-alpha_col toa-contrib">'."\n";
									echo '<h2 class="toa-txt-delta toa-font-alpha">' . $title . '</h2>'."\n";

								// Get the block's list items number
								$list_items 	= get_post_meta( $post_id, 'recrutement_content_' . $count . '_recrutement_list', true );

								if ( $list_items ) {

									echo '<ul>';

									for ( $i = 0; $i < $list_items; $i++ ) {

										// First: $count, which equals to the number of the flexible row, and then: $i, which equals to the number of the repeater field within that row.
										$list_item = esc_html( get_post_meta( $post_id, 'recrutement_content_' . $count . '_recrutement_list_' . $i . '_recrutement_list_item', true ) );

										if ($list_item) 
											echo '<li>' . $list_item . '</li>';

									}

									echo '</ul>';
								}

								echo '</div>'."\n";
								echo '</div>'."\n";
								echo '</div>'."\n";

							break;
								


							/**
							 * TEXT LAYOUT (+/- level 2 title)
							 */
							case 'recrutement_layout_title_text';

								$title = esc_html( get_post_meta( $post_id, 'recrutement_content_' . $count . '_recrutement_text_title', true ) );
								$content = get_post_meta( $post_id, 'recrutement_content_' . $count . '_recrutement_text', true );

								if ( $content)
									echo '<div class="toa-section">'."\n";
									echo '<div class="toa-layout-alpha_content">'."\n";
									echo '<div class="toa-layout-alpha_col toa-contrib">'."\n";
								
								// Get the block's title, if any
								if( $title )
									echo '<h2 class="toa-txt-delta toa-font-alpha">' . $title . '</h2>';

								// Get the block's content
								if( $content )
									echo apply_filters( 'the_content', $content );
									echo '</div>'."\n";
									echo '</div>'."\n";
									echo '</div>'."\n";

							break;
						}
					}
				?>
			</div>
		</div>

		<div class="rm-grid-container">
			<div class="toa-layout-beta">
				<div class="toa-layout-beta_content">

					<?php 

					/**
					 * APPLICATION LINK
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
					<div class="toa-layout-beta_col">
						<p class="toa-txt-delta toa-font-alpha">
							<a href="mailto:<?php echo $acf_job_emails_mailto; ?>">
								Postulez
							</a>
						</p>
					</div>
					<?php endif; endif; ?>

					<div class="toa-layout-beta_col">
						<p class="toa-txt-delta toa-font-alpha">
							Partagez sur <a href="https://twitter.com/home?status=<?php the_permalink(); ?>" title="Partager cette offre d'emploi sur Twitter">Twitter</a> ou sur <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" title="Partager cette offre d'emploi sur Facebook">Facebook</a>
						</p>
					</div>

				</div>
			</div>
		</div>

	</div>

</article>

<?php

/**
 * RELATED JOB OFFERS
 * Not using YARPP because it's another plugin and it's too much of a headache.
 */

// Setting up the loop
$args = array(

	// Only display projects
	'post_type' 		=> 'recrutement',

	// Display all similar posts with no limit of time
	'posts_per_page' 	=> 3,

	// Exclude the current post
	'post__not_in' 		=> array($post_id),

	// Order the posts according to the Simple Page Ordering plugin
	'orderby' 			=> 'menu_order',
	'order' 			=> 'ASC'
);

// The loop
$related_joboffers = null;
$related_joboffers = new WP_Query( $args );

// Print something only if the loop as something to offer.
if ( $related_joboffers->have_posts() ) :

?>
<aside class="rm-grid-container toa-section toa-sep-top">
	<h2 class="toa-font-alpha">
		Autres offres :
	</h2>
	<div class="toa-layout-beta toa-jobs-list toa-jobs-related">
		<ul class="toa-layout-beta_content">
			<?php 

			while ( $related_joboffers->have_posts() ) : $related_joboffers->the_post(); 

			?>
			<li class="toa-layout-beta_col toa-jobs-list_item">
				
				<h2 class="toa-txt-delta toa-font-alpha toa-jobs-list_title">
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>

				<?php

				$excerpt = get_the_excerpt();

				 if( !empty($excerpt) ) : echo '<p>' . esc_html( $excerpt ) . '</p>'; endif; ?>

			</li>
			<?php endwhile; ?>
		</ul>
	</div>
</aside>
<?php endif; wp_reset_query(); ?>