<?php
/**
 * @package toa
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('toa-project'); ?>>
	<header class="entry-header toa-project_header">


		<div class="rm-grid-container">
			<div class="toa-layout-delta">
				<div class="toa-layout-delta_col-first">
				<?php 

				/** 
				 * CATCH PHRASE
				 */

				// Before doing anything, check the get_field function exists to avoid PHP errors.
				if ( function_exists( 'get_field' ) ) : 

					$project_catch_phrase = get_field('project_catch_phrase');

					if ( isset($project_catch_phrase) && !empty($project_catch_phrase) ) :

				?>
				<p class="toa-project_subtitle toa-font-alpha">
					<?php the_field('project_catch_phrase'); ?>
				</p>
				<?php 

					endif; 
				endif; 
				/** */



				/** 
				 * PROJECT'S TITLE
				 */
				the_title( '<h1 class="toa-txt-beta">', '</h1>' ); 
				/** */



				/** 
				 * PROJECT'S LEAD-IN
				 */

				// Before doing anything, check the get_field function exists to avoid PHP errors.
				if ( function_exists( 'get_field' ) ) : 

					$project_lead_in = get_field('project_lead_in');

					if ( isset($project_lead_in) && !empty($project_lead_in) ) :

						echo wpautop($project_lead_in);

					endif;

				endif;
				/** */


				/**
				 * EDIT LINK for admins
				 */
				edit_post_link( __('Edit This'), '<p class="post-edit-link-container">', '</p>' );

				?>
				</div>
				<div class="toa-layout-delta_col-last">
				<?php


				/** 
				 * PROJECT'S META
				 */

				// Before doing anything, check the get_field function exists to avoid PHP errors.
				if (function_exists( 'get_field' ) ) : 

					$project_year_start = get_field('project_year_start');
					$project_year_end 	= get_field('project_year_end');
					$project_norm 		= get_field('project_norm');
					$project_awards		= get_field('project_awards');
					$project_status		= get_field('project_status');

					if (
								isset($project_year_start) 
							|| 	isset($project_year_end) 
							|| 	isset($project_norm) 
							|| 	isset($project_awards) 
							|| 	isset($project_status) 

						) :

						echo '<ul class="rm-list-sweet-lines toa-font-alpha">'."\n";


						/**
						 * PROJECT'S STATUS
						 */
						if ( isset($project_status) && !empty($project_status) ) : 


							echo '<li>Projet ';

							if ( $project_status == 'complete' ) :

								echo " réalisé";

							elseif ( $project_status == 'processing' ) :

								echo " en cours";

							endif;


							/**
							 * PROJECT'S START YEAR
							 */
							if ( isset($project_year_start) && !empty($project_year_start) ) : 

								echo ' (' . $project_year_start;

								/**
								 * PROJECT'S END YEAR
								 */
								if ( isset($project_year_end) && !empty($project_year_end) ) : 

									echo ' - ' . $project_year_end;

								endif;
								/** */

								echo ')';

							endif;
							/** */

							echo '</li>';

						endif;
						/** */


						/**
						 * PROJECT'S NORM
						 */
						if ( isset($project_norm) && !empty($project_norm) ) : 

							echo '<li>' . $project_norm . '</li>';

						endif;


						if ( isset($project_awards) && !empty($project_awards) ) : 

							echo '<li>' . $project_awards . '</li>';

						endif;

						echo '</ul>'."\n";

					endif;


				endif; 
				/** */

				?>
				</div>
			</div>
		</div>
	</header>

	<div class="entry-content toa-project_content">
	
		<?php 

		//
		// Before doing anything, check the get_field function exists to avoid PHP errors.
		// @TODO: remove any ACF dependency! (cf. content-recrutement.php)
		//
		if ( function_exists( 'get_field' ) ) : 

			// Check if the flexible content field has rows of data
			if( have_rows('project_structure') ):

			    // Loop through the rows of data
			    while ( have_rows('project_structure') ) : the_row();


					/**
			         * IMAGE
			         */
			        if( get_row_layout() == 'project_layout_image' ) :

			        	$project_image = get_sub_field('project_image');

			        	if ( !empty($project_image) ) : echo '<div class="toa-asset-fullwidth"><img src="' . $project_image['sizes']['very-large-picture'] . '" alt="' . $project_image['alt'] . '" width="' . $project_image['sizes']['very-large-picture-width'] . '" height="'. $project_image['sizes']['very-large-picture-height'] . '" /></div>'; endif;

			        /**
			         * GALLERIES
			         */
			        elseif( get_row_layout() == 'project_gallery_2cols' || get_row_layout() == 'project_gallery_4cols' ) :

			        
			        	/**
			        	 * GALLERY 4 COLUMNS
			        	 */
			        	if ( get_row_layout() == 'project_gallery_4cols' ) : 

			        		// Retrieve the pictures' IDs
			        		$project_gallery_2cols = get_sub_field('project_gallery4', false, false);

			        		// Define the number of gallery rows
			        		$project_gallery_row = '4';


			        	/**
			        	 * GALLERY 2 COLUMNS (default)
			        	 */
			        	else : 

			        		// Retrieve the pictures' IDs
			        		$project_gallery_2cols = get_sub_field('project_gallery2', false, false);

			        		// Define the number of gallery rows
			        		$project_gallery_row = '2';

			        	endif;


						if( isset($project_gallery_2cols) && !empty($project_gallery_2cols) ) : 

							// Prepare the gallery shortcode
							$gallery_shortcode = '[gallery columns="' . $project_gallery_row . '" ids="'. implode(',', $project_gallery_2cols) . '" size="gallery" link="none"]';

							// Echo gallery
							echo do_shortcode( $gallery_shortcode );

						endif;


			        /**
			         * TEXT
			         */
			        elseif( get_row_layout() == 'project_layout_text' ) :

			        	$project_wysiwyg = get_sub_field('project_wysiwyg');

			        	// Properly escaping the contributed content.

						$project_wysiwyg = wp_kses( 
							$project_wysiwyg,
						
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

					?>
					<div class="rm-grid-container toa-section">
						<div class="toa-layout-eta">
							<div class="toa-layout-eta_content">
								<div class="toa-layout-eta_col toa-contrib">
									<?php 

										echo wpautop($project_wysiwyg);

									?>
								</div>
					        </div>
				       </div>
			        </div>
			        <?php


			        /**
			         * QUOTE
			         */
			        elseif( get_row_layout() == 'project_layout_quote' ) :


			        	$project_quote_content 	= get_sub_field('project_quote_content');
			        	$project_quote_author 	= get_sub_field('project_quote_author');

			        	/**
		        		 * QUOTE'S CONTENT
		        		 */
			        	if ( isset($project_quote_content) && !empty($project_quote_content) ) :
			        	?>
			        <div class="rm-grid-container toa-section">
						<div class="toa-layout-eta">
							<div class="toa-layout-eta_content">
								<div class="toa-layout-eta_col toa-contrib">
								<?php

					        		echo '<blockquote>' . wpautop(esc_html($project_quote_content));
					        		echo "\n";

					        		/**
					        		 * QUOTE'S AUTHOR
					        		 */
					        		if ( isset($project_quote_author) && !empty($project_quote_author) ) :
					        			echo '<footer>' . esc_html($project_quote_author) . '</footer>';
					        		endif;
					        		/** */

					        		echo '</blockquote>';
					        	?>
					        	</div>
					        </div>
			        	</div>
			        </div>
			        <?php

			        	endif;
			        	/** */


			        /**
			         * VIDEO
			         */
			        elseif( get_row_layout() == 'project_layout_video' ) :

						$project_video_url = get_sub_field('project_video_url');

						if ( !empty($project_video_url) ) : 

							echo '<div class="toa-asset-fullwidth">' . apply_filters('the_content', $project_video_url) . '</div>';

						endif;


			        ?>
			    	


			    	<?php

			        endif;
			    	/** */


			    endwhile;

			endif;
			/** */



			/**
			 * TECHNICAL DETAILS
			 */
			// check if the repeater field has rows of data
			if ( have_rows('project_technical_details') ) :

			?>
			<div class="rm-grid-container">
				<div class="toa-layout-eta">
					<div class="toa-layout-eta_content">
						<div class="toa-layout-eta_col">
							<?php

								echo '<h2 class="toa-font-alpha">Fiche technique</h2>'."\n";
								echo '<ul class="toa-project_defs toa-txt-beta">'."\n";

							 	// loop through the rows of data
							    while ( have_rows('project_technical_details') ) : the_row();

							    	$project_detail_title 	= get_sub_field('project_detail_title');
							    	$project_detail_content = get_sub_field('project_detail_content');


							    	echo '<li class="toa-project_def">'."\n";
							    	echo '<div class="toa-project_def-title toa-font-alpha">';

							    	// Properly escaping the contributed content.
									echo wp_kses( 
										$project_detail_title,
									
										// Only allow <abbr>
										array(
											'abbr' => array(
										  		// Here, we whitelist the 'title' for better a11y
										  		'title' => array()
											)
										)
									);

									echo '</div>' . "\n";

							    	echo '<div class="toa-project_def-content">';

							    	// Properly escaping the contributed content.
									echo wp_kses( 
										$project_detail_content,
									
										// Only allow <abbr>
										array(
											'abbr' => array(
										  		// Here, we whitelist the 'title' for better a11y
										  		'title' => array()
											)
										)
									);

									echo '</div>' . "\n";
									echo '</li>' . "\n";

							    endwhile;

							    echo '</ul>'."\n";
							?>
						</div>
					</div>
				</div>
			</div>
			<?php

			endif;
			/** */



			/**
			 * PRESS RELEASE
			 */
			$project_pdf 		= get_field('project_pdf');


			if ( isset($project_pdf) && !empty($project_pdf) ) :

				$project_pdf_size 	= filesize(get_attached_file($project_pdf));
			
				echo '<div class="rm-grid-container toa-section">'."\n";
				echo '<div class="toa-project_press">'."\n";
				echo '<p class="toa-sep-double toa-txt-beta toa-font-alpha"><a href="' . esc_url(wp_get_attachment_url($project_pdf)) . '">Télécharger le dossier de presse</a> <span class="toa-txt-minor">(' . human_filesize($project_pdf_size) . ')</span></p>'."\n";
				echo '</div>'."\n";
				echo '</div>'."\n";

			endif;
			/** */


		endif;

		?>
	</div>

</article>


<?php

/**
 * RELATED POSTS
 * Not using YARPP because it's another plugin and it's too much of a headache.
 */

// Get the current post's ID 
$current_post_ID = get_the_ID();

// Get the current post's category
$cats = get_the_terms( $current_post_ID , 'cat_projet' );
$cats_array = [];

// Loop over each item since it's an array
if ( $cats != null ) :

	foreach( $cats as $cat ) :

		// Print the name method from $term which is an OBJECT
		$cats_array[] 	= $cat->term_id;
		$cat_name  		= $cat->name;

		// Get rid of the other data stored in the object, since it's not needed
		unset($cat);

	endforeach;

endif;


// Setting up the loop
$args = array(

	// Only display projects
	'post_type' 		=> 'projet',

	// Display all similar posts with no limit of time
	'posts_per_page' 	=> -1,

	// Select posts from the same taxonomy as the current post
	'tax_query' => array(
		array(
			'taxonomy' => 'cat_projet',
			'field'    => 'term_id',
			'terms'    => $cats_array
		),
	),

	// Exclude the current post
	'post__not_in' 		=> array($current_post_ID),

	// Only display posts that are featured
	'meta_query' 		=> array(
		array(
			'key'     	=> 'project_feature_listing',
			'value'   	=> '1',
			'compare' 	=> '=',
		),
	),

	// Order the posts according to the Simple Page Ordering plugin
	'orderby' 			=> 'menu_order',
	'order' 			=> 'ASC'
);

// The loop
$related_projects = null;
$related_projects = new WP_Query( $args );

// Print something only if the loop as something to offer.
if ( $related_projects->have_posts() ) :

?>
<aside class="rm-grid-container toa-section toa-projects-related<?php if ( !get_field('project_pdf')) : ?> toa-sep-top<?php endif; ?>">
	<h2 class="toa-font-alpha">
		Autres projets « <?php echo $cat_name; ?> »
	</h2>
	<div class="toa-layout-zeta">
		<ul class="toa-layout-zeta_content">
			<?php 

			while ( $related_projects->have_posts() ) : $related_projects->the_post(); 

			$project_ID 	= get_the_ID();
			$project_place 	= get_field('project_place', $project_ID );

			?>
			<li class="toa-layout-zeta_col">
				<div class="toa-projects-img-txt">
					<a href="<?php the_permalink(); ?>" class="rm-block">
						<div class="toa-project-img-txt_asset">
						<?php 

							$attr = array(
								'alt'	=> "",
								'title'	=> "",
							);

							echo get_the_post_thumbnail( get_the_ID(), 'large', $attr);
						?> 
						</div>
						<div class="toa-project-img-txt_content">
							<h3 class="toa-projects-related_title toa-font-alpha">
								<span><?php the_title(); ?></span>
							</h3>
							<?php if (isset($project_place) && !empty($project_place)) : ?>
							<span class="toa-projects-related_subtitle">
								<?php echo $project_place; ?>
							</span>
							<?php endif; ?>
						</div>
					</a>
				</div>
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
</aside>
<?php endif; wp_reset_query(); ?>