<?php

/*
 * @package Starck-theme
 *
 * description: The Main header plugin
*/

if ( !defined( 'ABSPATH' ) ) exit;

$page_id = get_queried_object_id();
$gallery = get_post_meta( $page_id, 'gallery-image' );
$gallery_in_slider = get_post_meta( $page_id, 'gallery-in-slider' );
$main_header_background = starck_get_option( 'content_header_background' );

if ( $gallery_in_slider && $gallery || $main_header_background ) {

	$parallax = starck_get_option( 'content_header_background' ) ? 'parallax' : '';
	$count_gallery = ($gallery) ? count($gallery) : 0;

	if ( $count_gallery > 1 ) {
		$gallery_scroll 	= ( 'on' === get_post_meta( $page_id, 'gallery-autoscroll', true )) ? 'true' : 'false';
		$gallery_pagination = ( 'on' === get_post_meta( $page_id, 'gallery-pagination', true )) ? 'true' : 'false';
		?>
		<section id="main-header">
			<div class="jcarousel-wrapper">
				<div class="jcarousel" data-jcarouselautoscroll="<?php echo $gallery_scroll ?>">
					<ul>
						<?php
						$i = 1;
						foreach ($gallery as $value) {
							$caption = wp_get_attachment_caption( absint($value) );
							echo sprintf('<li slide="%1$s" class="slide %2$s"  src-url="%4$s"><img class="lazyload" src="%3$s" data-srcset="%5$s" data-sizes="auto" />%6$s</li>',
								$i++,
								$parallax,
								wp_get_attachment_image_url( absint($value), 'thumbnail' ),
								wp_get_attachment_image_url( absint($value), 'full' ),
								wp_get_attachment_image_srcset( absint($value), 'full' ),
								($caption ? '<div class="image-caption">' . $caption . '</div>' : '')
							);
						}
						?>
					</ul>
				</div>
				<?php if ( is_single() ) {
					global $projects;
					$parent_term = wp_get_post_terms( $page_id , $projects['taxonomy'], array( 'orderby' => 'parent', 'order' => 'DESC' ) )[0];
					echo '<a class="parent-category" title="' . sprintf( __('Return to %s','starck'), $parent_term->name) . '" rel="nofollow" href="'.get_term_link($parent_term->term_id, $projects['taxonomy']).'">'.$parent_term->name.'</a>';
				} ?>
				<a href="#" class="jcarousel-control prev"><svg class="arrow-icon left"><use xlink:href="#arrow"></use></svg></a>
				<a href="#" class="jcarousel-control next"><svg class="arrow-icon right"><use xlink:href="#arrow"></use></svg></a>
				<div class="jcarousel-pagination" data-jcarouselpagination ="<?php echo $gallery_pagination ?>"></div>

				<?php
				$gallery_caption = get_post_meta( $page_id, 'gallery-caption', true );
				$gallery_caption_link = get_post_meta( $page_id, 'gallery-caption-link', true );

				if ( $gallery_caption ) {
					?>
					<div class="gallery-meta gallery-id-<?php echo $page_id ?>">
						<p class="gallery-caption"><?php echo $gallery_caption ?></p>
						<?php
						if ( $gallery_caption_link ) {
							?>
							<a class="gallery-link" href="<?php esc_url($gallery_caption_link) ?>">
								<div class="button"><?php echo __( 'Detail', 'starck' ) ?></div>
							</a>
							<?php
						}
						?>
					</div>
					<?php
				}

				if ( starck_get_option( 'scroll_up' ) ) {
					?>
					<div id="scroll-up" alt="<?php __( 'Scroll', 'starck' ) ?>"><i class="icon arrow down"></i></div>
					<?php
				}
				?>

			</div>
		</section>
		<?php
	} else {
		if ( $count_gallery == 1 )
			$image_url = wp_get_attachment_image_url(absint($gallery[0]), 'full' );
		else
			$image_url = $main_header_background;
		?>
		<section id="main-header" <?php echo sprintf('class="header-background %1$s" style="background-image: url(%2$s)"',
			$parallax,
			$image_url
		);?>>
		</section>
		<?php
	}
}
