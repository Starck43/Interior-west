<?php 
/*
 * The template for displaying all single posts
 *
 * @package Starck-theme
 */
get_header(); 

?>

<section id="content" <?php starck_content_class('single'); ?>>

	<?php starck_breadcrumbs(); ?>
	
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'entry' ); ?>
	<?php endwhile;?>

	<?php //get_template_part( 'nav', 'below-single' ); ?>
	<?php get_template_part( 'contact', 'form' ); ?>

</section>

<?php starck_get_sidebar();

get_footer(); 
?>