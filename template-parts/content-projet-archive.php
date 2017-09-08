<?php
/**
 * The template used for displaying projects on the "projet" CPT archive and on the "cat_projet" category pages.
 *
 * @package toa
 */

$project_place 	= get_field('project_place');

?>
<li class="toa-projects-alpha_col toa-projects-list_post">
	<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
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
					<?php //the_title( '<h2 class="toa-txt-delta">', '</h2>' ); ?>
					<?php the_title( '<h2 class="toa-project-list_title toa-font-alpha"><span>', '</span></h2>' ); ?><?php if (isset($project_place) && !empty($project_place)) : ?>
					<p class="toa-project-list_subtitle"><?php echo $project_place; endif; ?></p>
				</div>
			</a>
		</div>
	</article>
</li>