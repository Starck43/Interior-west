<?php 
/*

 * The template for Projects portfolio
 *
 * @package Starck-theme 

   Template Name: Projects Template
   Template Post Type: page
 */

get_header();

global $post;

$header_class = get_post_meta( $post->ID, 'hide-title', true ) ? 'hidden' : '';
$content = $post->post_content;

?>

<?php starck_breadcrumbs(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'entry' ); ?>
	<?php endwhile;?>

	<div id="projects">
		
		<?php get_taxonomy_list_categories($projects); ?>
		<div id="projects-portfolio">

			<?php get_template_part( 'entry','projects' ); ?>
			<?php

			//render_partial('entry-projects.php', ['projects' => $projects]); // передаем переменные в подключаемый шаблон
			?>

		</div>

		<?php //get_template_part( 'nav', 'below' ); ?>
	</div>


<?php get_footer(); ?>