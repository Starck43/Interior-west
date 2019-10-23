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
		<?php

			// Выводим все термы для таксономии project_cat
		$terms = get_terms( array( 
			'taxonomy' => 'project_cat',
			'orderby' => 'name',
			'hide_empty' => true,
		) );
		if ( $terms ) {
			?> 
			<ul id="projects-categories" class="projects-categories">
				<li class="cat-item-all current-cat"><a href="/projects">Все проекты</a></li>

				<?php
				foreach ($terms as $term) { ?>
					<li class="cat-item cat-item-<?php echo $term->term_id ?>"><a href="/projects/<?php echo $term->slug ?>" data-category-id="<?php echo $term->term_id ?>"><?php echo $term->name;?></a></li>
				<?php 
				}
				?>
			</ul>
			<?php
		}
			//var_dump($terms);
		?>

		<div id="projects-portfolio" class="row">

			<?php 
			$args = array( 
				'post_type' => 'projects',
				'posts_per_page' => 10,
				'order' => 'ASC',
				'orderby' => 'name',
			);
			 ?>
			<?php
			render_partial('entry-projects.php', ['args' => $args]);
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