<?php 
/*

 * The Project taxonomy template to show portfolio
 *
 * @package Starck-theme 
 *
 */

get_header();

global $post;

?>
	<section id="content" <?php starck_content_class('projects-category'); ?>>

		<?php starck_breadcrumbs(); ?>
		<div id="projects-portfolio" class="row">
			<?php
			get_template_part( 'entry','projects' );
			?>
		</div>
	</section>

<?php get_footer(); ?>