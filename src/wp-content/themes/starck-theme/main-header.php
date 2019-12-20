<?php

/*
 * @package Starck-theme
 *
 * description: The Main header plugin
 * Version: 1.8.6
*/

if ( !defined( 'ABSPATH' ) ) exit;

$page_id = get_queried_object_id();
$gallery = get_post_meta( $page_id, 'gallery-image' );
$gallery_in_slider = get_post_meta( $page_id, 'gallery-in-slider' );
$main_header_background = starck_get_option( 'content_header_background' );

if ( $gallery_in_slider && $gallery || $main_header_background ) {

	$parallax = starck_get_option( 'content_header_background' ) ? ' parallax' : '';
	$count_gallery = ($gallery) ? count($gallery) : 0;

	if ( $count_gallery > 1 ) {
		$gallery_scroll 	= ( 'on' === get_post_meta( $page_id, 'gallery-autoscroll', true )) ? 'true' : 'false';
		$gallery_pagination = ( 'on' === get_post_meta( $page_id, 'gallery-pagination', true )) ? 'true' : 'false';
		$gallery_control = ( 'on' === get_post_meta( $page_id, 'gallery-control', true )) ? 'true' : 'false';
		?>
		<section id="main-header">
			<div class="jcarousel-wrapper lazyload">
				<div class="jcarousel" data-jcarouselautoscroll="<?php echo $gallery_scroll ?>">
					<ul>
						<?php
						$i = 1;
						foreach ($gallery as $value) {
							$thumbnail = wp_get_attachment_image_url( absint($value), 'thumbnail' );
							$image = wp_get_attachment_metadata( absint($value) );
							$image_ratio = $image['height']/$image['width'];
							echo sprintf('<li slide="%1$s" class="slide%2$s">%6$s<img class="lazyload%5$s" src="%3$s" data-srcset="%4$s" data-sizes="auto" /></li>',
								$i++,
								$parallax,
								$thumbnail,
								wp_get_attachment_image_srcset( absint($value) ),
								($image_ratio > 1 ? ' fit-contain' : ''),
								($image_ratio > 1 ? '<div class="header-background blur-bg" style="background-image: url('.$thumbnail.')"></div>' : '')
								//wp_get_attachment_caption( absint($value) ) ? '<div class="image-caption">' . $caption . '</div>' : ''
							);
						}
						?>
					</ul>
				</div>
				<?php

				if (true === $gallery_control) {
				?>
					<a href="#" class="jcarousel-control prev"><svg class="arrow-icon left"><use xlink:href="#arrow"></use></svg></a>
					<a href="#" class="jcarousel-control next"><svg class="arrow-icon right"><use xlink:href="#arrow"></use></svg></a>
				<?php
				}
				if (true === $gallery_pagination) {
				?>
					<div class="jcarousel-pagination" data-jcarouselpagination ="<?php echo $gallery_pagination ?>"></div>
				<?php
				}
				$gallery_caption = get_post_meta( $page_id, 'gallery-caption', true );
				$gallery_caption_link = get_post_meta( $page_id, 'gallery-caption-link', true );

				if ( $gallery_caption ) {
					?>
					<div class="gallery-meta gallery-id-<?php echo $page_id ?>">
						<p class="gallery-caption"><?php echo $gallery_caption ?></p>
						<?php
						if ( $gallery_caption_link ) {
							?>
							<a class="gallery-link" href="<?php echo esc_url(wp_validate_redirect($gallery_caption_link)); ?>">
								<div class="button"><?php echo __( 'View', 'starck' ) ?></div>
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
