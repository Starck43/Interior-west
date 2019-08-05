<?php get_header(); ?>

	<section id="content" <?php starck_add_classes( 'content' ); ?> role="main">

		<header class="entry-header">
			<?php the_post(); ?>
			<h1 class="entry-title author"><?php the_author_link(); ?></h1>
			<div class="archive-meta"><?php if ( '' != get_the_author_meta( 'user_description' ) ) { echo esc_html( get_the_author_meta( 'user_description' ) ); } ?></div>
			<?php rewind_posts(); ?>
		</header>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'entry' ); ?>
		<?php endwhile; ?>

		<?php get_template_part( 'nav', 'below' ); ?>

	</section>

	<?php get_starck_sidebar(); ?>

<?php get_footer(); ?>