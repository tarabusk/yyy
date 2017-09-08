<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package toa
 */

/**
 * Different styles needed on the homepage.
 */



$html_attributes = 'no-js';

if (is_front_page()) : 

	$html_attributes .= ' home-html toa-layout-dark';


	// Get the latest five projects
	// $args = array(
	// 	'post_type'			=> 'projet',
	// 	'posts_per_page'	=> 1,
	// 	'order' 			=> 'ASC',
	// 	'orderby'			=> 'menu_order'
	// );

	// $loop = new WP_Query( $args );
	
	// if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();

	// 	// Retrieve the project's background-image
	// 	$latest_project_background = get_field('project_background');
	// 	$html_attributes .= ' style="background-image:url('.$latest_project_background['url'].');"';

	// endwhile; endif;

endif;

?><!DOCTYPE html>
<html <?php language_attributes(); if (isset($html_attributes)) : echo ' class="'. $html_attributes . '"'; endif; ?> data-theme-url="<?php echo get_template_directory_uri() . '/'; ?>">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="shortcut icon" href="<?php bloginfo('url'); ?>/favicon.ico" />
		<link rel="icon" href="<?php bloginfo('url'); ?>/favicon.ico" type="image/x-icon" />
		<link rel="icon" type="image/png" href="<?php bloginfo('url'); ?>/favicon.png" />
		<link rel="icon" type="image/png" href="<?php bloginfo('url'); ?>/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="<?php bloginfo('url'); ?>/android-chrome-192x192.png" sizes="192x192">
		<link rel="icon" type="image/png" href="<?php bloginfo('url'); ?>/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="<?php bloginfo('url'); ?>/favicon-16x16.png" sizes="16x16">
		<link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('url'); ?>/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('url'); ?>/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('url'); ?>/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('url'); ?>/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('url'); ?>/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('url'); ?>/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('url'); ?>/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('url'); ?>/apple-touch-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('url'); ?>/apple-touch-icon-180x180.png">
		<link rel="manifest" href="<?php bloginfo('url'); ?>/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php bloginfo('url'); ?>/mstile-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="pinterest" content="nopin" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		
		<?php wp_head(); ?>
	</head>

	<!--[if IE 9]><body <?php body_class('ie ie9'); ?>><![endif]-->
	<!--[if lte IE 8]><body <?php body_class('ie ie-legacy'); ?>><![endif]-->
	<!--[if !IE]>--><body <?php body_class(); ?>><!--<![endif]-->
		<div id="page" class="hfeed site toa-page">

			<!--[if lte IE 8]>
			<div id="no-ie8">
				<p><b>Votre version d'Internet Explorer est obsolète.</b></p>
				<p>Pour visiter ce site, veuillez <a href="http://windows.microsoft.com/fr-fr/windows/upgrade-your-browser">mettre à jour votre navigateur</a> s'il vous plaît.</p>
			</div>
			<![endif]-->

			<header id="toa-header" class="toa-header toa-font-alpha" role="banner">
				<div class="rm-grid-container">
					<div class="toa-txt-beta">
						<div class="toa-header_content">
							<div class="toa-header-title">
								<?php

								// Setting up some variables
								$site_title = "";


								// Building the site's title, with a link to the main site (except on the main site's homepage, obviously)
								if ( is_front_page() ) :

									$site_title .= '<h1>'."\n";

								else :

									$site_title .= '<p>'."\n";
									$site_title .= '<a href="'. esc_url( home_url( '/' ) ) .'" rel="home" class="rm-block">'."\n";

								endif;

								$site_title .= get_bloginfo('name');

								if ( is_front_page() ) :

									$site_title .= '</h1>'."\n";

								else :

									$site_title .= '</a>'."\n";
									$site_title .= '</p>'."\n";

								endif;

								// Printing the site's title
								echo $site_title."\n";


								?>
							</div>

							<nav id="toa-header-nav" class="toa-header-nav" role="navigation">
								<button class="toa-header-nav_toggle js-toggle-target" aria-owns="toa-header-nav_list" aria-expanded="false" data-toggle-parent="#toa-header-nav" title="Afficher le menu principal">
									<span>
										<span>Afficher le menu principal</span>
									</span>
								</button>
								<?php wp_nav_menu( array( 'theme_location' => 'header', 'menu_id' => 'toa-header-nav_list', 'menu_class' => 'toa-header-nav_list', 'container_class' => 'toa-header-nav_content', 'container_id' => 'toa-header-nav_content' ) ); ?>
							</nav>
						</div>
					</div>
				</div>
			</header>

			<div id="content" class="site-content toa-content">