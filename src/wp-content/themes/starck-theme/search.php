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

			<h1 class="search-title"><?php printf( esc_html__( 'Search Results for: %s', 'starck' ), get_search_query() ); ?></h1>
			<div class="post-count">( <?php esc_html_e('Found by request: ', 'starck'); ?><span><?php echo $wp_query->found_posts; ?></span> )</div>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
			<?php endwhile; ?>

			<?php get_template_part( 'nav', 'below' ); ?>

		<?php else : ?>

			<div class="entry-content post-0 no-result not-found">

				<h1 class="search-title"><?php esc_html_e( 'Nothing Found', 'starck' ); ?></h1>
				<div>
					<p><?php esc_html_e( 'Sorry, nothing matched your search. Please try again', 'starck' ); ?></p>
					<?php get_search_form(); ?>
				</div>

			</div>

		<?php endif; ?>

	</section>

	<?php starck_get_sidebar(); ?>

<?php get_footer(); ?>