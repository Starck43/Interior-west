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

	<section id="projects">

		<?php starck_breadcrumbs(); ?>
	
		<header id="projects-header">
			<h1 class="projects-title <?php echo $header_class ?>"><?php single_post_title(); ?></h1>
			<?php if ($content) { ?>
				<div class="projects-description"><p><?php echo $content; ?></p></div>
			<?php } ?>
		</header>

		<?php
			// Выводим все категории для таксономии project_cat

			if ( $terms = get_terms( array( 
					'taxonomy' => 'project_cat',
					'orderby' => 'name',
					'hide_empty' => true,
				) ) ) {

				?> 
            	<ul id="projects-categories">
					<li><a href="#">Все</a></li>

					<?php
					foreach ($terms as $term): ?>
						<li><a href="#" data-category-id="<?php echo $term->term_id?>"><?php echo $term->name;?></a></li>
					<?php endforeach; ?>

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