<?php 
/*

 * The Project taxonomy template to show portfolio
 *
 * @package Starck-theme 
 *
 */

get_header();

global $projects;

?>

<?php starck_breadcrumbs(); ?>

	<section id="projects">
	
		<?php 
			$term = get_the_terms($post, $projects['taxonomy'])[0];
			get_projects_categories($projects, $term->slug);
		?>	
		<div id="projects-portfolio" class="row">
			<?php
			get_template_part( 'entry','projects' );
			?>
		</div>

	</section>

<?php get_footer(); ?>