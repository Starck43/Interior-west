<?php get_header(); ?>

	<section id="content" <?php starck_add_classes( 'content','tags' ); ?> role="main">

		<header class="entry-header">

			<h1 class="entry-title"><?php single_term_title(); ?></h1>
			<div class="archive-meta">
				<?php if ( '' != the_archive_description() ) { echo esc_html( the_archive_description() ); } ?>
			</div>

		</header>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'entry' ); ?>
		<?php endwhile; endif; ?>

		<?php get_template_part( 'nav', 'below' ); ?>

	</section>

	<?php get_starck_sidebar(); ?>

<?php get_footer(); ?>