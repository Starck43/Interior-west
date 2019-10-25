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

	<section id="projects">

		<article class="entry post-<?php the_ID(); ?>" <?php post_class(); ?>>	
			<header id="projects-header">
				<h1 class="entry-title <?php echo $header_class ?>"><?php single_post_title(); ?></h1>
			</header>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry','content' ); ?>
			<?php endwhile;?>
		</article>
		
		<?php get_taxonomy_list_categories($projects); ?>

		<div id="projects-portfolio" class="row">

			<?php 
			$args = array( 
				'post_type' => $projects['post_type'],
				'posts_per_page' => 10,
				'order' => 'ASC',
				'orderby' => 'name',
			);
			 ?>
			<?php
			render_partial('entry-projects.php', ['args' => $args, 'projects' => $projects]); // передаем переменные в подключаемый шаблон
			//get_template_part( 'entry','projects' );
			?>

		</div>

		<?php
		if( $max_pages > 1 ) { // если страниц больше одной, то выводим кнопку с data-атрибутом следующей страницы
		 ?>
			<a id="projects-load-more" href="#" data-page="2">Показать еще</a> 
		<?php 
		}
		?>

		<?php //get_template_part( 'nav', 'below' ); ?>

	</section>


<?php get_footer(); ?>