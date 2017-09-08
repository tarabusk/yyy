<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package toa
 */

$display_greeting_card 		= get_option('options_display_greeting_card');
$display_greeting_card_img 	= get_option('options_display_greeting_card_img');

if (isset($display_greeting_card_img) && !empty($display_greeting_card_img)) :
	$display_greeting_card_img = wp_get_attachment_image_src($display_greeting_card_img, 'fullsize')[0];
endif;

?>

			</div><?php /* #content */ ?>
		</div><?php /* #page */ ?>

		<footer id="toa-footer" class="toa-footer toa-font-alpha" role="contentinfo">
			<div class="rm-grid-container">
				<nav id="toa-footer-nav" class="toa-footer-nav toa-txt-beta" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'toa-footer-nav_list', 'menu_class' => 'toa-footer-nav_list rm-list-inline-block', 'container_class' => 'toa-footer-nav_content', 'container_id' => 'toa-footer-nav_content' ) ); ?>
				</nav>
			</div>
		</footer>



		<!--[if ! lte IE 8]><!-->
		<?php if (isset($display_greeting_card) && $display_greeting_card == 'oui' && !empty($display_greeting_card_img)) : ?>
		<div id="rm-popin" class="rm-popin js-popin">
			<div id="rm-popin-overlay" class="rm-popin-overlay"></div>
			<div id="rm-popin-content" class="rm-popin-content">
				<div class="rm-popin-content_in-1">
					<div class="rm-popin-content_in-2">
						<img src="<?php echo $display_greeting_card_img; ?>" alt="Bonne année !" />
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		<?php wp_footer(); ?>

		<?php /*if (current_user_can('edit_themes')) : ?>
		<script>
		jQuery(function(){
		  var grid = new hashgrid({ numberOfGrids: 5 });
		});
		</script>
		<?php endif;*/ ?>
		<!--<![endif]-->

	</body>
</html>
