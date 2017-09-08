<?php
/**
 * The template used for displaying "presse" single posts that match the "dossiers de presse" taxonomy
 *
 * @package toa
 */

/**
 * PRESS RELEASE
 */
$acf_press_item_pdf 		= get_post_meta( get_the_ID(), 'press_release_pdf', true );;

if ( isset($acf_press_item_pdf) && !empty($acf_press_item_pdf) ) :

$acf_press_item_pdf_size 	= filesize(get_attached_file($acf_press_item_pdf));

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('toa-layout-zeta_col'); ?>>
	<div class="toa-img-txt">
		<a href="<?php echo esc_url(wp_get_attachment_url($acf_press_item_pdf)); ?>" class="rm-block">
			<div class="toa-img-txt_asset">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'press-release'); ?> 
			</div>
			<div class="toa-img-txt_content toa-txt-beta">
				<h2 class="toa-img-txt_title toa-font-alpha">
					<?php the_title(); ?>
				</h2>
				<span class="toa-img-txt_subtitle">Télécharger<span class="rm-visually-hidden"> le dossier de presse</span> <span class="toa-txt-minor">(<?php echo human_filesize($acf_press_item_pdf_size); ?>)</span></span>
			</div>
		</a>
	</div>
</article>
<?php endif; ?>