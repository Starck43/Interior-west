<?php

/*
 * description: The Main header plugin
 * author: S.Shabalin
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
		<header id="main-header">
			<div class="jcarousel-wrapper">
				<div class="jcarousel" data-jcarouselautoscroll="<?php echo $gallery_scroll ?>">
					<ul>
						<?php
						$i = 1;
						foreach ($gallery as $value) {
							//$i++;
							echo sprintf('<li slide="%1$s" class="header-background %2$s" style="background-image: url(%3$s);"></li>',
								$i++,
								$parallax,
								wp_get_attachment_image_url(absint($value), 'full' )
							);
						}
						?>
					</ul>
				</div>
				<a href="#" class="jcarousel-control prev"><i class="fa arrow-left"></i></a>
				<a href="#" class="jcarousel-control next"><i class="fa arrow-right"></i></a>
				<p class="jcarousel-pagination" data-jcarouselpagination ="<?php echo $gallery_pagination ?>"></p>
			</div>
		<?php					
	} else {
		if ( $count_gallery == 1 )
			$image_url = wp_get_attachment_image_url(absint($gallery[0]), 'full' );
		else 
			$image_url = $main_header_background;
		?>
		<header id="main-header" <?php echo sprintf('class="header-background %1$s" style="background-image: url(%2$s)"',
											$parallax,
											$image_url
										);
		?>>
		<?php
	} 

	$gallery_caption = get_post_meta( $page_id, 'gallery-caption', true );
	$gallery_caption_link = get_post_meta( $page_id, 'gallery-caption-link', true );

	if ( $gallery_caption ) {
		?>
		<div id="main-header-excerpt">
			<p><?php echo $gallery_caption ?></p>
		</div>
		<?php
	}

	if ( $gallery_caption_link ) {
		?>
		<a id="main-header-link" href="<?php esc_url($gallery_caption_link) ?>"><div class="button">Подробнее</div></a>
		<?php 
	}

	if ( starck_get_option( 'scroll_up' ) ) {
		?>
		<div id="scroll-up" alt="Пролистать"><i class="icon fa fa-long-arrow-alt-down"></i></div>
		<?php 
	}
	?>

	</header>

	<?php
}
