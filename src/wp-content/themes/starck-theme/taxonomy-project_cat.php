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

	<div id="projects">
		<?php $term = get_queried_object(); ?>
		<?php get_category_meta( $projects, $term ); ?>
		<?php get_taxonomy_list_categories( $projects, $term ); ?>
		<div id="projects-portfolio" class="row">
			<?php get_template_part( 'entry','projects' ); ?>
		</div>
	</div>

<?php get_footer(); ?>