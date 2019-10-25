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
	
		<?php get_taxonomy_list_categories($projects); ?>

		<div id="projects-portfolio" class="row">
			<?php
			get_template_part( 'entry','projects' );
			?>
		</div>

	</section>

<?php get_footer(); ?>