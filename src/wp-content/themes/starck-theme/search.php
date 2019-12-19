<?php

/*
 * The template for displaying search results
 *
 * @author: S.Shabalin
 */

get_header();

?>

	<section id="content" class="search search-result" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="entry-header">
				<h1 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'starck' ), get_search_query() ); ?></h1>
			</header>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
			<?php endwhile; ?>

			<?php get_template_part( 'nav', 'below' ); ?>

		<?php else : ?>


			<header class="entry-header">
				<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'starck' ); ?></h1>
			</header>
			<div class="entry-content post-0 no-result not-found">
				<p><?php esc_html_e( 'Sorry, nothing matched your search. Please try again', 'starck' ); ?></p>
				<?php get_search_form(); ?>
			</div>

		<?php endif; ?>

	</section>

	<?php starck_get_sidebar(); ?>

<?php get_footer(); ?>