<?php get_header(); ?>

<main id="main">

	<section id="content" <?php starck_add_classes( 'content'); ?> role="main">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'entry' ); ?>
			<?php if ( comments_open() && ! post_password_required() ) { comments_template( '', true ); } ?>
		<?php endwhile; endif; ?>

		<?php get_template_part( 'nav', 'below-single' ); ?>

	</section>

	<?php get_starck_sidebar(); ?>

</main>

<?php get_footer(); ?>