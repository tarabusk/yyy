<?php
/**
 * The template used for displaying page content on the “Contact” page.
 *
 * @package toa
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title rm-visually-hidden">', '</h1>' ); ?>
	</header>

	<div class="entry-content">
		<?php //the_content(); ?>

		<?php 

			/**
			 * AGENCIES
			 */
			if ( have_rows('contact_agencies')) :

		?>
		<div class="rm-grid-container">
			<div class="toa-layout-gamma toa-section">
				<div class="toa-layout-gamma_content">
				<?php	
				
					while ( have_rows('contact_agencies') ) : the_row();

						$agency_zone 		= get_sub_field('zone');
						$agency_street 		= get_sub_field('address_street');
						$agency_secundary 	= get_sub_field('address_secundary');
						$agency_postcode 	= get_sub_field('address_postcode');
						$agency_city 		= get_sub_field('address_city');
						$agency_phone 		= get_sub_field('phone');
						$agency_fax 		= get_sub_field('fax');

						if ($agency_zone && $agency_street && $agency_postcode && $agency_city) :
					?>
					<div class="toa-layout-gamma_col">
						<?php

							if ( isset($agency_zone) && !empty($agency_zone) ) :

						?>
						<h2 class="entry-title toa-txt-gamma toa-font-alpha">
							<?php echo esc_html($agency_zone); ?>
						</h2>
						<?php

							endif;

							if ( isset($agency_street) && !empty($agency_street) ||  isset($agency_phone) && !empty($agency_phone) || isset($agency_fax) && !empty($agency_fax)) :

						?>
						<p>
						<?php 

								//
								// DISPLAY ADDRESS
								//

								// Display street
								echo esc_html($agency_street);

								// Display secundary address info
								if ( isset($agency_secundary) && !empty($agency_secundary) ) : 
									echo ' / ' . esc_html($agency_secundary); 
								endif; 

								// Display postcode
								if ( isset($agency_postcode) && !empty($agency_postcode) ) : 
									echo ' / ' . esc_html($agency_postcode); 
								endif;
							
								// Display city
								if ( isset($agency_city) && !empty($agency_city) ) : 

									if ( !isset($agency_postcode) || empty($agency_postcode) ) : 
										echo ' /'; 
									endif;
									
									echo ' ' . esc_html($agency_city); 

								endif; 



								//
								// DISPLAY PHONE AND FAX NUMBERS
								//
								if ( isset($agency_phone) && !empty($agency_phone) || isset($agency_fax) && !empty($agency_fax) ) :

									echo '<br />';

									// Display phone number
									if ( isset($agency_phone) && !empty($agency_phone) ) :
										echo '<abbr title="Téléphone">T.</abbr> ' . esc_html($agency_phone);
									endif;

									if ( isset($agency_phone) && !empty($agency_phone) && isset($agency_fax) && !empty($agency_fax) ) :
										echo ' / ';
									endif;

									// Display fax number
									if ( isset($agency_fax) && !empty($agency_fax) ) :
										echo '<abbr title="Fax">F.</abbr> ' . esc_html($agency_fax);
									endif;

								endif;

						?>
						</p>
						<?php

							/**
							 * EDIT LINK for admins
							 */
							edit_post_link( __('Edit This'), '<p class="post-edit-link-container">', '</p>' );

						?>
						<?php 


							endif; 
						?>
					</div>
				<?php

						endif;

					endwhile;

				?>
				</div>
			</div>
		</div>
		<?php 

			endif;

			//
			//
			//

			/**
			 * DISPLAY GALLERY
			 */
			$agency_images 		= '';
			$i 					= 0;

			while ( have_rows('contact_agencies') ) : the_row();

				// Retrieving the image's ID
				$agency_image 			= get_sub_field('image')['id'];

				if ($i > 0) :
					$agency_images .= ',';
				endif;

				$agency_images .= $agency_image;
				$i++;

			endwhile;

			echo do_shortcode('[gallery ids="'. $agency_images .'" columns="2" size="gallery" link="none"]'); 



			/**
			 * DISPLAY CONTACT FORM
			 */

			if ( rm_gravity_form_exists('1')) :

		?>
		<div class="rm-grid-container toa-form">
			<h2 class="toa-txt-gamma toa-font-alpha">
				Contactez-nous
			</h2>
			<div class="toa-layout-alpha">
				<div class="toa-layout-alpha_content">
					<div class="toa-layout-alpha_col">
						<?php gravity_form('1', false, false, false, false, false ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php 

			endif; 

		?>
	</div>

		
</article>
