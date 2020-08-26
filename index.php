<?php
/**
 * The main template file
 *
 * @package TestOrb\Theme
 */

namespace TestOrb\Theme;

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			// Start the loop.
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
					</header><!-- .entry-header -->

					<section class="entry-content">
						<?php the_content(); ?>
					</section>

					<footer class="entry-footer">
						<?php the_category(); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->
				<?php
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous page', 'twentysixteen' ),
					'next_text'          => __( 'Next page', 'twentysixteen' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
				)
			);
		else :
			?>
			<article class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title">Nothing Found</h1>
				</header><!-- .page-header -->

				<section class="page-content">
					<p>It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.</p>
					<?php get_search_form(); ?>
				</section>
			</article>
			<?php
		endif;
		?>

		</main>
	</div>
<?php

get_sidebar();
get_footer();
