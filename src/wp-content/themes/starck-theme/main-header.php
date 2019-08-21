<?php

/*
 * description: The Main header plugin
 * author: S.Shabalin
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


global $post;
$header_class = '';

$main_header_background = starck_get_option( 'content_header_background' );
//$main_header_gallery = starck_get_option( 'content_header_gallery' );
$gallery 			= get_post_meta( $post->ID, 'gallery-image' );
$gallery_scroll 	= ( 'on' === get_post_meta( $post->ID, 'gallery-autoscroll', true )) ? 'true' : 'false';
$gallery_pagination = ( 'on' === get_post_meta( $post->ID, 'gallery-pagination', true )) ? 'true' : 'false';

if ( $main_header_background && count($gallery) < 2 ) {
	$header_class = sprintf('class="header-background paralax" style="background-image: url(%s)"', $main_header_background);

} 

?>  
<header id="main-header" <?php echo $header_class; ?>>
	

	<?php
	if ( $gallery ) {
		?>
		<div class="jcarousel-wrapper">
			<div class="jcarousel" data-jcarouselautoscroll="<?php echo $gallery_scroll ?>">
				<ul>
					<?php
					$i = 1;
					foreach ($gallery as $value) {
						//$i++;
						echo sprintf('<li slide="%1$s" class="header-background parallax" style="background-image: url(%2$s);"></li>',$i++,$value);
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

	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, fuga aliquid iusto beatae harum ipsa officiis ad ipsam sequi voluptatibus minima dolore hic delectus, eos alias nemo excepturi consequatur inventore.</p>
	<div id="main-header-link"><div class="button">Подробнее</div></div>

</header>
<?php 


