<?php
/**
 * The template for displaying search results pages.
 *
 * @package toa
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<div class="rm-grid-container">
					<div class="toa-layut-alpha">
						<div class="toa-layut-alpha_content">
							<div class="toa-layut-alpha_col">
								<h1 class="page-title">Résultats de recherche pour : <?php echo get_search_query(); ?></h1>
							</div>
						</div>
					</div>
				</div>
			</header>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'archive' );
				?>

			<?php endwhile; ?>

			<?php toa_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main>
	</section>

<?php get_footer(); ?>
