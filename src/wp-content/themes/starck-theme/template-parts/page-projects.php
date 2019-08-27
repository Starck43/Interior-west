<?php 
/*

 * The template for portfolio
 *
 * @package Starck-theme 

   Template Name: Portfolio Template
   Template Post Type: page
 */
 
get_header(); ?>

	<section id="content" <?php starck_content_class('projects'); ?>>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'entry' ); ?>
		<?php endwhile;?>

		<?php get_template_part( 'nav', 'below' );

		?>

	</section>

	<?php starck_get_sidebar(); ?>

<?php get_footer(); ?>