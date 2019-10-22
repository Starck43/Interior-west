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
		while ( have_posts() ) : the_post(); 
		/* Query the post */
			$hide_title = get_post_meta( $post->ID, 'hide-title', true ) ? 'hidden' : '';
			$project_excerpt = get_the_excerpt();
			if ( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio') ) { 
				$image_ratio = 'style="padding-top: ' . ($image[2]/$image[1]*100) . '%"';
			}
			?>
			<a class="portfolio col-6" href="<?php echo get_permalink($post->ID) ?>">
				<div class="portfolio-container" <?php echo $image_ratio ?>>
					<img class="portfolio-image lazy" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $image[0]; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset(get_post_thumbnail_id( $post->ID ), 'medium' ); ?>" alt="Проект"/>
					<?php if ( !empty($hide_title) || !empty($project_excerpt) ) { ?>
						<div class="portfolio-image-meta">
							<h2 class="meta-title <?php echo $hide_title ?>"><?php the_title(); ?></h2>
							
							<div class="meta-description"><?php echo $project_excerpt; ?></div>
						</div>
					<?php } ?>
				</div>
			</a>
			<?php 
		endwhile; 
		?>	
		</div>
	</section>

<?php get_footer(); ?>