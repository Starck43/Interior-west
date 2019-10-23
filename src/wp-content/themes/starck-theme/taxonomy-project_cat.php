<?php 
/*

 * The Project taxonomy template to show portfolio
 *
 * @package Starck-theme 
 *
 */

get_header();

//global $post;

?>

<?php starck_breadcrumbs(); ?>

	<section id="projects">
	
			<?php

			// Выводим все термы для таксономии project_cat
		$terms = get_terms( array( 
			'taxonomy' => 'project_cat',
			'orderby' => 'name',
			'hide_empty' => true,
		) );
		if ( $terms ) {
			?> 
			<ul id="projects-categories">
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
			get_template_part( 'entry','projects' );
			?>
		</div>
	</section>

<?php get_footer(); ?>