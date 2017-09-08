<?php
/**
 * toa functions and definitions
 *
 * @package toa
 */

/**
 * Import ACF settings
 * /!\ Disable on dev environment.
 * /!\ Enable on preprod and prod environments.
 */
if ( defined('RM_ENV') && (RM_ENV === 'PROD' || RM_ENV === 'STAGING') ) {

    // Only call the ACF export in production.
    include_once( get_template_directory() . '/inc/acf-settings.php' );
}

/**
 * DEV ONLY!
 */
//add_action('wp_head', 'show_template');
function show_template() {

	if (current_user_can('activate_plugins')) :
		global $template;
		print_r($template);
	endif;
}




if ( ! function_exists( 'toa_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function toa_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on toa, use a find and replace
	 * to change 'toa' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'toa', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Locations to use wp_nav_menu() in the theme.
	 */
	register_nav_menus( array(
		'header' => esc_html__( 'Header', 'toa' ),
		'footer' => esc_html__( 'Footer', 'toa' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Remove support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	remove_theme_support('post-formats');

	/**
	 * Remove WordPress background feature.
	 */
	remove_theme_support('custom-background');

	/**
	 * Custom image sizes
	 */

	// Thumbnail: 150x150 – unused?
	// Ratio: 1

	// Medium: 385x385
	// Ratio: 1

	// Large: 800x527
	// Ratio: 0,66

	// Ratio: 1,05
	add_image_size('press-release', 			385, 	403, true); // used on the "Press releases" (dossiers de presse) archives


	// Ratio: 1
	add_image_size('associates', 				585, 	585, true);
	add_image_size('gallery-equipe', 			875, 	720, true);
	add_image_size('gallery', 					875, 	780, true);

	// Ratio: 0,41
	add_image_size('recrutement_rw',			700, 	288, true); // creating this image for responsive images on mobile + tablet. DO NOT USE IN THEME.
	add_image_size('recrutement', 				1750, 	720, true); // this image is displayed on the "recrutement" CPT's archive page and on the blog

	// Ratio: 0,56
	add_image_size('very-large-picture_rwd',	700, 	392, true); // creating this image for responsive images on mobile + tablet. DO NOT USE IN THEME.
	add_image_size('very-large-picture', 		1750, 	980, true); // this image can be displayed on single projects
	add_image_size('homepage', 					2000,  1120, true); // this image is displayed on the homepage


}
endif; // toa_setup
add_action( 'after_setup_theme', 'toa_setup' );


/**
 * Utilisation des tailles d'images custom depuis l'éditeur WordPress
 * @link http://wp.tutsplus.com/tutorials/theme-development/using-custom-image-sizes-in-your-theme-and-resizing-existing-images-to-the-new-sizes/
 */
function rm_custom_image_sizes_choose( $sizes )
{
	$custom_sizes = array(
		'gallery'				=> 'Format galerie',
		'very-large-picture'	=> 'Image très large'
	);
	return array_merge( $sizes, $custom_sizes );
}
add_filter( 'image_size_names_choose', 'rm_custom_image_sizes_choose' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
// function toa_content_width() {
// 	$GLOBALS['content_width'] = apply_filters( 'toa_content_width', 640 );
// }
// add_action( 'after_setup_theme', 'toa_content_width', 0 );


/**
 * Enqueue a IE-specific style sheet (for all browsers).
 *
 * @author Gary Jones
 * @link http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
 */
add_action( 'wp_enqueue_scripts', 'rm_add_main_stylesheet', 200 );
function rm_add_main_stylesheet() {

	global $wp_styles;

	/* Load the main stylesheet, preventing IE8 and lower to use it. */
	wp_enqueue_style( 'toa-style-not-ie', get_stylesheet_uri(), array(), '1.0.8', 'screen' );

	/* Load the print stylesheet */
	wp_enqueue_style( 'toa-style-print', get_stylesheet_directory_uri() . "/style-print.css", array(), '1.0.8', 'print' );

	/* Load our IE specific stylesheet for a range of older versions. */
	wp_enqueue_style( 'toa-style-old-ie', get_stylesheet_directory_uri() . "/style-lte-ie8.css", array(), '1.0.8', 'screen' );
 	$wp_styles->add_data( 'toa-style-old-ie', 'conditional', 'lte IE 8' );

}

/**
 * Add conditional comments around IE-specific style sheet link.
 *
 * @author Gary Jones & Michael Fields (@_mfields)
 * @link http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
 *
 * @param string $tag    Existing style sheet tag.
 * @param string $handle Name of the enqueued style sheet.
 *
 * @return string Amended markup
 */
add_filter( 'style_loader_tag', 'rm_add_main_stylesheet_conditional', 10, 2 );
function rm_add_main_stylesheet_conditional( $tag, $handle ) {

	if ( 'toa-style-not-ie' == $handle )

		// We need to change the conditional comment's syntax in order to be understood only by browsers that are not equal or less than IE8
		$tag = '<!--[if ! lte IE 8]><!-->' . "\n" . $tag . '<!--<![endif]-->' . "\n";

	return $tag;

}

/**
 * Enqueueing some JavaScript files
 */
function toa_scripts() {

	//
	// JAVASCRIPT
	//

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load Modernizr
	$last_update_modernizr	= filemtime( get_stylesheet_directory() . '/components/modernizr/modernizr.min.js' );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/components/modernizr/modernizr.min.js', '', $last_update_modernizr );

	// Load RM scripts
	$last_update_behaviours	= filemtime( get_stylesheet_directory() . '/assets/js/behaviours.min.js' );
	wp_enqueue_script( 'toa-behaviours', get_template_directory_uri() . '/assets/js/behaviours.min.js', array('jquery'), $last_update_behaviours, true );

	// $last_update_behaviours	= filemtime( get_stylesheet_directory() . '/assets/js/behaviours.js' );
	// wp_enqueue_script( 'toa-behaviours', get_template_directory_uri() . '/assets/js/behaviours.js', array('jquery'), $last_update_behaviours, true );

	//if (current_user_can('edit_themes')) :
		wp_enqueue_script('hashgrid', get_template_directory_uri() . '/components/hashgrid/hashgrid.js', array('jquery'), '1.0.0', true );
	//endif;

}
add_action( 'wp_enqueue_scripts', 'toa_scripts' );

/**
 * Implement the 'projet' custom post type
 */
require get_template_directory() . '/inc/cpt-projet.php';

/**
 * Implement the 'recrutement' custom post type
 */
require get_template_directory() . '/inc/cpt-recrutement.php';

/**
 * Implement the 'presse' custom post type
 */
require get_template_directory() . '/inc/cpt-presse.php';

/**
 * Implement the 'equipe' custom post type
 */
require get_template_directory() . '/inc/cpt-equipe.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom Résidence Mixte functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras-rm.php';

/**
 * Filter Yoast Meta Priority
 */
add_filter( 'wpseo_metabox_prio', function() { return 'low';});


/**
 * Hide the admin bar for not logged in users, and for users that don't have at leat the "publish_posts" capability
 */
function rm_hide_adminbar() {

	if (!is_user_logged_in() && !current_user_can('publish_posts')){

		add_filter('show_admin_bar', '__return_false');
	}
}
add_action( 'after_setup_theme', 'rm_hide_adminbar', 0 );

/**
 * Completley removing the comment functionality
 * @link https://www.dfactory.eu/wordpress-how-to/turn-off-disable-comments/
 */

	// Disable support for comments and trackbacks in post types
	function df_disable_comments_post_types_support() {
		$post_types = get_post_types();
		foreach ($post_types as $post_type) {
			if(post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}
	add_action('admin_init', 'df_disable_comments_post_types_support');

	// Close comments on the front-end
	function df_disable_comments_status() {
		return false;
	}
	add_filter('comments_open', 'df_disable_comments_status', 20, 2);
	add_filter('pings_open', 'df_disable_comments_status', 20, 2);

	// Hide existing comments
	function df_disable_comments_hide_existing_comments($comments) {
		$comments = array();
		return $comments;
	}
	add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

	// Remove comments page in menu
	function df_disable_comments_admin_menu() {
		remove_menu_page('edit-comments.php');
	}
	add_action('admin_menu', 'df_disable_comments_admin_menu', 999);

	// Redirect any user trying to access comments page
	function df_disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url()); exit;
		}
	}
	add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

	// Remove comments metabox from dashboard
	function df_disable_comments_dashboard() {
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	}
	add_action('admin_init', 'df_disable_comments_dashboard');

	// Remove comments links from admin bar
	function df_disable_comments_admin_bar() {
		if (is_admin_bar_showing()) {
			remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		}
	}
	add_action('init', 'df_disable_comments_admin_bar');

	// Remove some elements from the top admin bar: comments, WordPress stuff.
	function rm_remove_admin_bar_links() {
    	global $wp_admin_bar;
	    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
	    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
	    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
	    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
	    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
	    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
	    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
	}
	add_action('wp_before_admin_bar_render', 'rm_remove_admin_bar_links', 999 );
/** */


/*
 * Force medium and large images to crop
 * @link http://wordpress.org/support/topic/force-crop-to-medium-size
 */
if(false === get_option("medium_crop"))
	add_option("medium_crop", "1");
else
	update_option("medium_crop", "1");

if(false === get_option("large_crop"))
	add_option("large_crop", "1");
else
	update_option("large_crop", "1");


/**
 * Human Readable File Size with PHP
 * @link http://php.net/manual/fr/function.filesize.php#106569
 * @link http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
 */
function human_filesize($bytes, $decimals = 2) {
	$sz = array('b','Ko','Mo','Go','To');
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor];
}


/**
 * Disable emojis
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove tinymce emoji plugin.
 *
 * @param    array  $plugins
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}



/**
 * Add an Options page
 */
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Options du thème',
		'menu_title'	=> 'Options',
		'menu_slug' 	=> 'theme-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Recrutement',
		'menu_title'	=> 'Recrutement',
		'parent_slug'	=> 'theme-options'
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Équipe',
		'menu_title'	=> 'Équipe',
		'parent_slug'	=> 'theme-options'
	));
}



/**
 * Wrap content's images with the appropriate div, and close any .rm-grid-container open div.
 */
// function rm_content_images( $content ) {

// 	// A regular expression of what to look for.
// 	$pattern = '/(<img([^>]*)>)/i';

// 	// Close the .rm-grid-container div and open a .toa-asset-fullwidth div, then open another .rm-grid-container div.
// 	$replacement = '</div>
// 					<div class="toa-asset-fullwidth">
// 						$1
// 					</div>
// 					<div class="rm-grid-container">';

//    // Run preg_replace() on the $content
//    $content = preg_replace( $pattern, $replacement, $content );

//    // Return the processed content
//    return $content;
// }

// add_filter( 'the_content', 'rm_content_images' );


/*
function add_class_to_image($html, $id, $caption, $title, $align, $url, $size, $alt='') {
    $html_to_add_start 	= '</div>
							<div class="toa-asset-fullwidth">';
	$html_to_add_end 	= '</div>
							<div class="rm-grid-container">';

    if (preg_match('/<a.? class=".?">/', $html))
        $html = preg_replace('/(<a.? class=".?)(".\?>)/', '$1 ' . $classes_to_add . '$2', $html);
    else
        $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes_to_add . '">', $html);
    return $html;
}

add_filter( 'the_content', 'add_class_to_image' );
*/

/**
 * Check if a Gravity Form exists
 * @link https://www.gravityhelp.com/forums/topic/check-if-form-exists
 */
function rm_gravity_form_exists($form_id){

  $forms = GFFormsModel::get_forms();
	foreach($forms as &$form){
		if ($form->id == $form_id) {
			return true;
		}
	}
  return false;
}


/**
 * Completely remove tags
 */
add_action( 'admin_menu', 'myprefix_remove_meta_box');
function myprefix_remove_meta_box(){
	remove_meta_box( 'tagsdiv-post_tag','post','normal' );
}

add_action('init', 'remove_tags');
function remove_tags(){
	register_taxonomy('post_tag', array());
}

/**
 * Actions to do if ACF is active
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) )
{
	/**
	 * Add a "paste" button to ACF's TinyMCE "Basic" toolbar
	 * @link https://codex.wordpress.org/Function_Reference/is_plugin_active
	 * @link http://support.advancedcustomfields.com/forums/topic/how-do-you-add-text-color-button-to-tinymce-basic-toolbar/
	 */
	add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
	function my_toolbars( $toolbars ) {
		array_unshift( $toolbars['Basic' ][1], 'paste' );
		return $toolbars;
	}

	/**
	 * ACF: set the 'project_background' image as post thumbnail
	 * @link http://support.advancedcustomfields.com/forums/topic/set-image-as-featured-image/
	 * acf/update_value/name={$field_name} - filter for a specific field based on it's name
	 */
	add_filter('acf/update_value/name=project_background', 'acf_set_featured_image', 10, 3);
	add_filter('acf/update_value/name=equipe_partner_picture', 'acf_set_featured_image', 10, 3);

	function acf_set_featured_image( $value, $post_id, $field  ){

	    if($value != ''){

	    	// Delete previous post thumbnail
	    	delete_post_thumbnail( $post_id);

		    // Add the value which is the image ID to the _thumbnail_id meta data for the current post
		    add_post_meta($post_id, '_thumbnail_id', $value);
	    }

	    return $value;
	}
}

add_action('wp_footer', 'add_google_analytics');
function add_google_analytics() { ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63513494-1', 'auto');
  ga('send', 'pageview');

</script>
<?php

}

/**
 * Gravity Forms: load scripts in footer
 * @author https://bjornjohansen.no/load-gravity-forms-js-in-footer
 */
add_filter('gform_init_scripts_footer', '__return_true');


/**
 * @subsection Sanitize Uploads Name to Prevent 404
 * @link https://wpchannel.com/renommer-automatiquement-fichiers-accentues-wordpress/
 */
add_filter('sanitize_file_name', 'wpc_sanitize_french_chars', 10);

function wpc_sanitize_french_chars($filename) {

    // Force the file name in UTF-8 (encoding Windows / Mac / Linux)
	$filemane = mb_convert_encoding($filename, "UTF-8");

    $char_not_clean = array('/@/','/À/','/Á/','/Â/','/Ã/','/Ä/','/Å/','/Ç/','/È/','/É/','/Ê/','/Ë/','/Ì/','/Í/','/Î/','/Ï/','/Ò/','/Ó/','/Ô/','/Õ/','/Ö/','/Ù/','/Ú/','/Û/','/Ü/','/Ý/','/à/','/á/','/â/','/ã/','/ä/','/å/','/ç/','/è/','/é/','/ê/','/ë/','/ì/','/í/','/î/','/ï/','/ð/','/ò/','/ó/','/ô/','/õ/','/ö/','/ù/','/ú/','/û/','/ü/','/ý/','/ÿ/', '/©/');
    $clean = array('a','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','u','u','u','u','y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y','copy');

    $friendly_filename = preg_replace($char_not_clean, $clean, $filename);

    // After replacement, we destroy the last residues
    $friendly_filename = utf8_decode($friendly_filename);
    $friendly_filename = preg_replace('/\?/', '', $friendly_filename);

    // Lowercase
    $friendly_filename = strtolower($friendly_filename);

    return $friendly_filename;
}

/**
 * Get size information for all currently-registered image sizes.
 *
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 * @return array $sizes Data for all currently-registered image sizes.
 */
function get_image_sizes() {
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}

	return $sizes;
}

/**
 * Get size information for a specific image size.
 *
 * @uses   get_image_sizes()
 * @param  string $size The image size for which to retrieve data.
 * @return bool|array $size Size data about an image size or false if the size doesn't exist.
 */
function get_image_size( $size ) {
	$sizes = get_image_sizes();

	if ( isset( $sizes[ $size ] ) ) {
		return $sizes[ $size ];
	}

	return false;
}

/**
 * Get the width of a specific image size.
 *
 * @uses   get_image_size()
 * @param  string $size The image size for which to retrieve data.
 * @return bool|string $size Width of an image size or false if the size doesn't exist.
 */
function get_image_width( $size ) {
	if ( ! $size = get_image_size( $size ) ) {
		return false;
	}

	if ( isset( $size['width'] ) ) {
		return $size['width'];
	}

	return false;
}

/**
 * Get the height of a specific image size.
 *
 * @uses   get_image_size()
 * @param  string $size The image size for which to retrieve data.
 * @return bool|string $size Height of an image size or false if the size doesn't exist.
 */
function get_image_height( $size ) {
	if ( ! $size = get_image_size( $size ) ) {
		return false;
	}

	if ( isset( $size['height'] ) ) {
		return $size['height'];
	}

	return false;
}
