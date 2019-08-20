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
$gallery = get_post_meta( $post->ID, 'gallery-image' );

if ( $main_header_background && count($gallery) < 2 ) {
	$header_class = sprintf('class="header-background paralax" style="background-image: url(%s)"', $main_header_background);

} 

?>  
<header id="main-header" <?php echo $header_class; ?>>
	<?php
	if ( $gallery ) {
		?>
		<div class="jcarousel-wrapper">
			<div class="jcarousel">
				<ul>
					<?php
					foreach ($gallery as $value)
						echo '<li class="header-background parallax" style="background-image: url('.$value.');"></li>';
					?>
				</ul>
			</div>
			<a href="#" class="jcarousel-control prev"><span class="fa fa-chevron-left"></span></a>
			<a href="#" class="jcarousel-control next"><span class="fa fa-chevron-right"></span></a>
			<p class="jcarousel-pagination"></p>
		</div>

		<?php					
	}
	?>
	<div class="header-container">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, fuga aliquid iusto beatae harum ipsa officiis ad ipsam sequi voluptatibus minima dolore hic delectus, eos alias nemo excepturi consequatur inventore.</p>
		<div class="button">Подробнее</div>
	</div>
</header>
<?php 


