<?php 

get_header(); 

$header_class = get_post_meta( $post->ID, 'hide-title', true ) ? 'hidden' : '';

?>

	<section id="content" <?php starck_content_class(); ?>>
	
		<?php starck_breadcrumbs(); ?>
		
		<header class="category-header">
			<h1 class="entry-title <?php echo $header_class ?>"><?php single_term_title(); ?></h1>
			<div class="archive-meta"><?php if ( '' != the_archive_description() ) { echo esc_html( the_archive_description() ); } ?></div>
		</header>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'entry' ); ?>
		<?php endwhile; endif; ?>

		<?php get_template_part( 'nav', 'below' ); ?>

	</section>

	<?php starck_get_sidebar(); ?>

<?php get_footer(); ?>