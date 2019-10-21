<?php
/*
 * The single template for project
 *
 * @package Starck-theme 

 */
get_header();

global $post;

?>

	<section id="content" <?php starck_content_class('project'); ?>>

		<?php starck_breadcrumbs(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php
			$gallery = get_post_meta( $post->ID, 'gallery-image' );
			$gallery_in_slider = get_post_meta( $post->ID, 'gallery-in-slider' );
			?>

			<article class="entry post-<?php the_ID(); echo (!$gallery_in_slider ? ' row' : ''); ?>" <?php post_class(); ?>>

				<?php 
				if ( has_post_thumbnail() && !$gallery_in_slider ) {
					$cell_classes = 'cell col-md-6';
					?>
					<div class="<?php echo $cell_classes; ?>">
						<?php the_post_thumbnail('portfolio'); ?>
					</div>
				<?php 
				}
				?>
				<div class="entry-content <?php echo $cell_classes; ?>">
					<header class="entry-header">
						<?php 
						$header_class = ' class="entry-title' . ((get_post_meta( $post->ID, 'hide-title', true )) ? ' hidden' : '');
						the_title( '<h1' . $header_class . '">', '</h1>' );
						?>
					</header>
			
					<?php the_content();?>
				</div>

				<?php 
				if ( $gallery && !$gallery_in_slider ) {
					?>
					<div id="portfolio-gallery" class="gallery">
						<?php 
						foreach ($gallery as $post_id) {
							$post_id = absint($post_id);
							$image = wp_get_attachment_metadata( $post_id );
							$thumb = $image['sizes']['medium']['file'];
							$image_ratio = $image['height']/$image['width']*100;
							$full_image = wp_get_attachment_url($post_id, 'full');
							$title =  get_the_title( $post_id );
							$caption = wp_get_attachment_caption( $post_id );
							?>
							<a class="gallery-image" href="<?php echo $full_image ?>">
								<div class="gallery-container" style="padding-top: <?php echo $image_ratio.'%' ?>">
									<img class="image lazy" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $thumb; ?>" data-srcset="<?php echo wp_get_attachment_image_srcset( $post_id, 'medium' ); ?>" alt="Gallery"/>
								</div>
								<div class="gallery-image-details">
									<div><h3><?php echo $title; ?></h3></div>
									<div><?php echo $caption; ?></div>
								</div>
							</a>
							<div class="gallery-caption"><?php echo $caption; ?></div>
							<?php 
						}
						?>				
					</div>
					<?php
				}
				edit_post_link(); 
				?>

			</article>
		<?php endwhile; ?>

		<?php get_template_part( 'nav', 'below-single' ); ?>
		<?php if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) { comments_template( '', true ); } ?>

	</section>

<?php get_footer(); ?>