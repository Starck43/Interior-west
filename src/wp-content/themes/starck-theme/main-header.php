<?php

/*
 * description: The Main header plugin
 * author: S.Shabalin
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$page_id = get_queried_object_id();

$header_class = '';
$main_header_background = starck_get_option( 'content_header_background' );
$gallery = get_post_meta( $page_id, 'gallery-image' );

if ($gallery || $main_header_background ) {

	$count_gallery = ($gallery) ? count($gallery) : 0;
	if ( $count_gallery == 1 || $main_header_background ) {
		if ($count_gallery == 1) {
			$image_url = wp_get_attachment_image_url(absint($gallery[0]), 'full' );
;
		} elseif ( $main_header_background ) {
			$image_url = $main_header_background;
		} 
		$header_class = sprintf('class="header-background parallax" style="background-image: url(%s)"', $image_url);
	}
	?>  
	<header id="main-header" <?php echo $header_class; ?>>

		<?php
		if ( $count_gallery > 1 ) {
			$gallery_scroll 	= ( 'on' === get_post_meta( $page_id, 'gallery-autoscroll', true )) ? 'true' : 'false';
			$gallery_pagination = ( 'on' === get_post_meta( $page_id, 'gallery-pagination', true )) ? 'true' : 'false';
			?>
			<div class="jcarousel-wrapper">
				<div class="jcarousel" data-jcarouselautoscroll="<?php echo $gallery_scroll ?>">
					<ul>
						<?php
						$i = 1;
						foreach ($gallery as $value) {
							//$i++;
							echo sprintf('<li slide="%1$s" class="header-background parallax" style="background-image: url(%2$s);"></li>',$i++,wp_get_attachment_image_url(absint($value), 'full' ));
						}
						?>
					</ul>
				</div>
				<a href="#" class="jcarousel-control prev"><span class="fa fa-chevron-left"></span></a>
				<a href="#" class="jcarousel-control next"><span class="fa fa-chevron-right"></span></a>
				<p class="jcarousel-pagination" data-jcarouselpagination ="<?php echo $gallery_pagination ?>"></p>
			</div>

			<?php					
		}
		?>

		<div id="main-header-excerpt">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, fuga aliquid iusto beatae harum ipsa officiis ad ipsam sequi voluptatibus minima dolore hic delectus, eos alias nemo excepturi consequatur inventore.</p>
		</div>
		<div id="main-header-link"><div class="button">Подробнее</div></div>

	</header>
	<?php
}
