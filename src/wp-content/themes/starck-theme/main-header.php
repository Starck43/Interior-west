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
	$header_class = sprintf('class="header-background" style="background-image: url(%s)"', $main_header_background);
	?>
	<script type="text/javascript">
		$(window).scroll( function() {
			// preset parallax for header background
			$('.header-background').bgParallax({
				speed: 0.25,
			});
		});
	</script>
	<?php
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
						echo '<li style="background: url('.$value.');"></li>';
					?>
				</ul>
			</div>
			<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
			<a href="#" class="jcarousel-control-next">&rsaquo;</a>
			<p class="jcarousel-pagination"></p>
		</div>
		<script type="text/javascript">


			$(function() {
				$('.jcarousel')
					.jcarousel({
						wrap: 'circular',
						animation:   800,
						transitions: Modernizr.csstransitions ? {
							transforms:   Modernizr.csstransforms,
							transforms3d: Modernizr.csstransforms3d,
							easing:       'ease'
						} : false
					})
					.jcarouselSwipe();
				
				$('.jcarousel-control-prev').jcarouselControl({
					target: '-=1'
				});

				$('.jcarousel-control-next').jcarouselControl({
					target: '+=1'
				});

				$('.jcarousel').jcarouselAutoscroll({
					autostart: false,
					interval:  5000,
					//target: '-=1',
				});
			});
		</script>
		<?php					
	}
	?>
	<div class="header-container">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, fuga aliquid iusto beatae harum ipsa officiis ad ipsam sequi voluptatibus minima dolore hic delectus, eos alias nemo excepturi consequatur inventore.</p>
		<div class="button">Подробнее</div>
	</div>
</header>
<?php 


