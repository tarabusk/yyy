<?php
/**
 * The template used for displaying projects on the "projet" CPT archive and on the "cat_projet" category pages.
 *
 * @package toa
 */

/**
 * Retrieve the item's possible link
 */
$acf_press_item_link 		= get_post_meta( get_the_ID(), 'press_release_pdf', true );

/**
 * Retrieve the item's description
 */
$acf_press_item_description = get_post_meta( get_the_ID(), 'press_description', true );

/**
 * Retrieve the item's type of link
 */
$acf_press_item_click_type = get_post_meta( get_the_ID(), 'press_click_type', true );
$acf_press_item_click_target = '';

if (isset($acf_press_item_click_target)) :
	switch($acf_press_item_click_type)
	{
		case 'file' :

			$acf_press_item_click_target = wp_get_attachment_url(get_post_meta( get_the_ID(), 'press_file', true ));

		break;

		case 'url' :

			$acf_press_item_click_target = get_post_meta( get_the_ID(), 'press_external_link', true );

		break;
	}

endif;


?>

<article id="post-<?php the_ID(); ?>" <?php post_class('toa-layout-alpha_col'); ?>>
	<div class="toa-txt-beta">
		<h2 class="rm-mb0">
			<?php if (isset($acf_press_item_click_target) && !empty($acf_press_item_click_target)) : ?>
			<a href="<?php echo $acf_press_item_click_target; ?>">
			<?php endif; ?>
				<span class="toa-font-alpha"><?php the_title(); ?></span>
			<?php if (isset($acf_press_item_click_target) && !empty($acf_press_item_click_target)) : ?>
			</a>
			<?php endif; ?>
		</h2>
		<?php if (isset($acf_press_item_description) && !empty($acf_press_item_description)) : ?>
		<p><?php echo $acf_press_item_description; ?></p>
		<?php endif; ?>
	</div>
</article>