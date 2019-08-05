<?php get_header(); ?>

	<section id="content" <?php starck_add_classes( 'content' ); ?> role="main">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'entry' ); ?>
			<?php comments_template(); ?>
		<?php endwhile; endif; ?>

		<?php get_template_part( 'nav', 'below' ); ?>

	</section>

	<?php get_starck_sidebar(); ?>

<?php get_footer(); ?>