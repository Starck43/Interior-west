<?php
/*
 * The single template for project
 *
 * @package Starck-theme

 */
get_header();

global $post;

?>

	<section id="content" <?php starck_content_class('project row'); ?>>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			$gallery = get_post_meta( $post->ID, 'gallery-image' );
			$gallery_in_slider = get_post_meta( $post->ID, 'gallery-in-slider' );
			if ( $gallery_in_slider ) $cell_classes = ' cell col-md-6';
			?>

			<article id="project-entry" class="entry post-<?php the_ID(); echo ($gallery_in_slider ? $cell_classes : ''); ?>" <?php post_class(); ?>>
				<?php
				$header_class = ' class="project-title' . ((get_post_meta( $post->ID, 'hide-title', true )) ? ' hidden' : '');
				$description = apply_filters( 'the_content', get_the_content() );
				if (!$description) $description = get_the_excerpt();
				?>
				<header class="entry-header">
					<?php the_title( '<h1' . $header_class . '">', '</h1>' ); ?>
				</header>
				<div class="project-content">
					<div class="entry-description">
						<?php echo $description; ?>
						<?php edit_post_link(); ?>
					</div>
					<?php if ( has_post_thumbnail() && !$gallery_in_slider ) the_post_thumbnail('full','class=lazyload'); ?>
				</div>

			</article>
			<?php
			if ( $gallery && !$gallery_in_slider ) {
				?>
				<div id="portfolio-gallery" class="gallery column-grid">
					<?php
					foreach ($gallery as $post_id) {
						$post_id = absint($post_id);
						$image = wp_get_attachment_metadata( $post_id );
						$thumb = $image['sizes']['medium']['file'];
						$image_ratio = $image['height']/$image['width']*100;
						$full_image_url = wp_get_attachment_url($post_id, 'full');
						$title =  get_the_title( $post_id );
						$caption = wp_get_attachment_caption( $post_id );
						?>
						<a class="gallery-image" href="<?php echo $full_image_url ?>">
							<div class="img-container" style="padding-top: <?php echo $image_ratio.'%' ?>">
								<img class="image lazyload" src="<?php echo $thumb; ?>" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="<?php echo wp_get_attachment_image_srcset( $post_id, 'medium' ); ?>" data-sizes="auto" data-expand="-50"/>
							</div>
							<div class="gallery-image-meta">
								<?php
								if ($title) { ?>
									<div class="gallery-image-title"><h3><?php echo $title; ?></h3></div>
								<?php
								}
								if ($caption) { ?>
									<div class="gallery-image-caption"><?php echo $caption; ?></div>
								<?php
								} ?>
							</div>
						</a>
						<?php
					}
					?>
				</div>
				<?php
			}

			?>
			<div class="feedback<?php echo $cell_classes; ?>"><p class="feedback-description"><?php echo __('If you like this, please, get in touch and we can discuss your project.', 'starck'); ?></p><?php echo do_shortcode(starck_get_option( 'form_shortcode_setting' ) ); ?></div>

		<?php endwhile; ?>

	</section>

<?php get_footer(); ?>