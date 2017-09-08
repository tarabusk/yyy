<?php
/**
 * The template used for displaying page content on the "Identité" page.
 *
 * @package toa
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="rm-grid-container">
		
			<div class="toa-layout-delta">
				<div class="toa-layout-delta_content">
					<div class="toa-layout-delta_col-first">
						<?php 

						// Has a custom ACF title be set up?
						$acf_about_catch_phrase = get_post_meta( get_the_ID(), 'about_catch_phrase' );

						// If it has, use it instead of the regular page title
						$page_title = ( !empty($acf_about_catch_phrase) ? $acf_about_catch_phrase[0] : get_the_title()); // returns true

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

	<?php 
	
	/**
	 * INITIALS
	 */	

	$args = array(
		'post_type' 			=> 'equipe',
		'meta_key' 				=> 'equipe_partner_associate',
		'posts_per_page' 		=> '3',

		// Order the posts according to the Simple Page Ordering plugin
		'orderby' 			=> 'menu_order',
		'order' 			=> 'ASC',

		'meta_query' 			=> array(
									array(
										'key'     => 'equipe_partner_associate',
										'value'   => '1',
										'compare' => '=',
									)
								)

	);

	$associates = null;
	$associates = new WP_Query($args);

	if( $associates->have_posts() ) : 
	
	?>
	<div class="rm-grid-container">
		<div class="toa-layout-zeta toa-team-initials" aria-hidden="true">
			<ul class="toa-layout-zeta_content">
				<?php 

				while ( $associates->have_posts() ) : $associates->the_post(); 

				$firstname = explode(" ", get_the_title())[0];

				?>
				<li class="toa-layout-zeta_col">
					<a href="<?php the_permalink(); ?>">
						<span data-associate-initial="<?php echo $firstname[0]; ?>">
							<span><?php echo $firstname; ?></span>
						</span>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
	<?php endif; wp_reset_query(); ?>
	
	<?php if($post->post_content != "" && $post->post_content != " "  ) : ?>
	<div class="rm-grid-container toa-section">
		<div class="toa-layout-alpha">
			<div class="toa-layout-alpha_content">
				<div class="toa-layout-alpha_col">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<?php 
	
	
	/**
	 * PAGE STRUCTURE
	 */
	$post_id = get_the_ID();
	$flexible_rows = get_post_meta( $post_id, 'about_structure', true );
	
	foreach( $flexible_rows as $count => $flexible_row ) :
	
		switch( $flexible_row ) :
		
			/**
	         * IMAGE
	         */
			case 'about_picture':
	
				$about_image 		= get_post_meta( $post_id, 'about_structure_' . $count . '_image' );
	        	
	        	if ( isset($about_image) && !empty($about_image) ) : echo '<div class="toa-asset-fullwidth">' . wp_get_attachment_image( $about_image[0], 'very-large-picture' ) . '</div>'; endif;
	
	        break;
	
	
	        /**
	         * IMPORTANT PARAGRAPH
	         */
	        case 'about_paragraph_important':
	
		        	$about_paragraph_important = get_post_meta( $post_id, 'about_structure_' . $count . '_text', true );
	
		        	// Properly escaping the contributed content.
	
					$about_paragraph_important = wp_kses( 
						$about_paragraph_important,
					
						// Only allow <a>, <abbr>, <strong>, <b>, <i> and <em> tags
						array(
							'a' => array(
						  		// Here, we whitelist 'href' and 'title' attributes - nothing else allowed!
						  		'href' => array(),
						  		'title' => array()
							),
							'abbr' => array(
						  		// Here, we whitelist the 'title' for better a11y
						  		'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'i' => array(),
							'strong' => array(),
							'b' => array(),
							'p' => array()
						)
					);
	
					if (isset($about_paragraph_important) && !empty($about_paragraph_important)) :
	
				?>
				<div class="rm-grid-container toa-section">
					<div class="toa-layout-alpha">
						<div class="toa-layout-alpha_content">
							<div class="toa-layout-alpha_col">
								<p class="toa-txt-alpha">
									<?php 
	
										echo $about_paragraph_important;
	
									?>
								</p>
							</div>
				        </div>
			       </div>
		        </div>
		        <?php
	
		        endif;
	
		    break;
	
	
	        /**
	         * LIST
	         */
	        case 'about_list':
	
				$about_list = get_post_meta( $post_id, 'about_structure_' . $count . '_value', true);
	
				if ( isset($about_list) && !empty($about_list) ) :
	
				?>
				<div class="rm-grid-container toa-section">
					<div class="toa-layout-alpha">
						<div class="toa-layout-alpha_content">
							<ul class="toa-layout-alpha_col">
							<?php 
	
							for ( $i = 0; $i < $about_list; $i++ ) :
	
								// Get the value's title
								$acf_value_title 	= get_post_meta( get_the_ID(), 'about_structure_' . $count . '_value_' . $i . '_title', true );
	
								// Get the value's description
								$acf_value_desc 	= get_post_meta( get_the_ID(), 'about_structure_' . $count . '_value_' . $i . '_desc', true );
	
								if ( !empty($acf_value_title) && !empty($acf_value_desc) ) :
	
							?>
								<li class="rm-mb">
									<h2 class="toa-txt-delta toa-font-alpha rm-mb05-i">
										<?php echo $acf_value_title; ?>
									</h2>
									<?php echo $acf_value_desc; ?>
								</li>
							<?php 
	
								endif;
	
							endfor;
	
							?>
							</ul>
						</div>
					</div>
				</div>
				<?php
	
				endif;
	
		        	break;
	
	
		        	/**
	         * SIMPLE PARAGRAPH
	         */
	        case 'about_paragraph':
	
		        	$about_paragraph = get_post_meta( $post_id, 'about_structure_' . $count . '_text', true );
	
		        	// Properly escaping the contributed content.
	
					$about_paragraph = wp_kses( 
						$about_paragraph,
					
						// Only allow <a>, <abbr>, <strong>, <b>, <i> and <em> tags
						array(
							'a' => array(
						  		// Here, we whitelist 'href' and 'title' attributes - nothing else allowed!
						  		'href' => array(),
						  		'title' => array()
							),
							'abbr' => array(
						  		// Here, we whitelist the 'title' for better a11y
						  		'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'i' => array(),
							'strong' => array(),
							'b' => array(),
							'p' => array()
						)
					);
	
					if ( isset($about_paragraph) && !empty($about_paragraph) ) :
	
				?>
				<div class="rm-grid-container toa-section">
					<div class="toa-layout-alpha">
						<div class="toa-layout-alpha_content">
							<div class="toa-layout-alpha_col">
								<?php 
	
									echo wpautop($about_paragraph);
	
								?>
							</div>
				        </div>
			       </div>
		        </div>
		        <?php
	
		        endif;
	
		    break;
	
		        endswitch;
		    	/** */
	
	endforeach;
	/** */
	
	?>

		
</article>