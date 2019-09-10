<?php 
/*

 * The template for Projects portfolio
 *
 * @package Starck-theme 

   Template Name: Projects Portfolio
   Template Post Type: page
 */

get_header();

global $post;

$header_class = get_post_meta( $post->ID, 'hide-title', true ) ? 'hidden' : '';
$content = $post->post_content;

?>

	<section id="content" <?php starck_content_class('projects'); ?>>

		<?php starck_breadcrumbs(); ?>

		<header class="projects-header">
			<h1 class="projects-title <?php echo $header_class ?>"><?php single_post_title(); ?></h1>
			<?php if ($content) { ?>
				<div class="projects-description"><?php echo $content; ?></div>
			<?php } ?>
		</header>

		<div id="projects-portfolio" class="portfolio">
			<?php
			$args = array( 'post_type' => 'projects', 'posts_per_page' => -1 );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); 
			/* Query the post */
				$hide_title = get_post_meta( $post->ID, 'hide-title', true ) ? 'hidden' : '';
				$project_excerpt = get_the_excerpt();
				if ( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium') ) { 
					$image_ratio = 'style="padding-top: ' . ($image[2]/$image[1]*100) . '%"';
				}
				?>
				<a <?php post_class("portfolio-image"); ?> href="<?php echo get_permalink($post->ID) ?>">
					<div class="portfolio-image-container" <?php echo $image_ratio ?>>
						<img class="image lazy" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $image[0]; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset(get_post_thumbnail_id( $post->ID ), 'medium' ); ?>" alt="Project"/>
						<?php if ( !empty($hide_title) || !empty($project_excerpt) ) { ?>
							<div class="portfolio-image-meta">
								<h4 class="image-title <?php echo $hide_title ?>"><?php the_title(); ?></h4>
								
								<div class="image-description"><?php echo $project_excerpt; ?></div>
							</div>
						<?php } ?>
					</div>
				</a>
			<?php 
			endwhile; 
			wp_reset_postdata();
			?> 
		</div>
		
		<?php get_template_part( 'nav', 'below' ); ?>

	</section>


<?php get_footer(); ?>