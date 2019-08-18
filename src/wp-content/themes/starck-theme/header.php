<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php esc_attr( bloginfo( 'charset' ) ); ?>" />
	<meta name="description" content="Starter web template for Wordpress">
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" href="img/favicon.png">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	$primary_args = array( 
		'theme_location' => 'primary',
		//'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul><div id="menu-icon" class="burger-menu">&#9776;</div>',
		//'container' => ''
	);
	$secondary_args = array( 
		'theme_location' => 'secondary',
		'fallback_cb' => '__return_empty_string', // show additional menu only if it exists
	);

	$custom_header = get_custom_header();
	if ( ! empty( $custom_header->attachment_id ) ) {
		$header_img_attr = sprintf(' style="background-image: url(%s)"', $custom_header->url);
		$background_class = 'header-background';
	}

	?>
	<header id="site-header" <?php starck_header_class(['site-header',$background_class]); echo $header_img_attr; ?>>
		<?php 
		if ( 'enabled' === starck_get_option( 'top_bar_layout_setting' ) ) {
			starck_get_top_bar();
		}
		?>

		<!-- header-container -->
		<div id="header-container" class="<?php echo 'container branding-' . starck_get_option( 'branding_alignment' ); ?>">
			<?php 
			$nav_position = starck_get_option( 'nav_position_setting' );
			if ( in_array($nav_position, ['above', 'below']) ) { 
			?>
				<nav id="header-nav" <?php starck_navigation_class(); ?> role="navigation">
					<?php wp_nav_menu( $primary_args ); ?>
					<?php wp_nav_menu( $secondary_args ); ?>
				</nav>
			<?php
			}
			?>		
			<section id="branding" <?php starck_branding_class('site-branding'); ?>>
				<?php
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				if ( $custom_logo_id ) {
				?>
				<!-- logo -->
	            <div id="branding-logo" class="site-logo">
					<?php the_custom_logo(); ?>
	            </div>
				<?php
				}
				?>
				<!-- header title -->
				<div id="branding-title">
					<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1 class="site-title">'; } ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
					<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; } ?>
					<div class="site-description"><?php bloginfo( 'description' ); ?></div>
				</div>
			</section>

			<section id="header-content" <?php echo 'class=align-' . ( "right" === starck_get_option( 'branding_alignment' ) ? 'left' : 'right') ?>>
				<?php 
				$nav_search_position = starck_get_option( 'nav_search_setting' );
				if ('front' == $nav_search_position) {
					echo '<div id="search-icon" class="search"></div>';
				}
				if ( 'inline' == $nav_position ) { 
				?>
					<nav id="header-nav" <?php starck_navigation_class(); ?> role="navigation">
						<?php wp_nav_menu( $primary_args ); ?>
						<?php wp_nav_menu( $secondary_args ); ?>
					</nav>
				<?php
				}
				if ('behind' == $nav_search_position) {
					echo '<div id="search-icon" class="search"></div>';
				}

				if ( starck_get_option( 'header_widget_setting' )) {
					starck_get_header_widget();
				}
				?>
				<div id="menu-icon" class="burger-menu">&#9776;</div>
				<div id="site-search" <?php starck_search_class('search'); ?>><?php get_search_form(); ?></div>
			</section>
		</div>
		<!-- end container -->
	</header>
	<?php 
	if ( 'under' == $nav_position ) { 
	?>
		<nav id="header-nav" <?php starck_navigation_class(); ?> role="navigation">
			<?php wp_nav_menu( $primary_args ); ?>
			<?php wp_nav_menu( $secondary_args ); ?>
		</nav>
	<?php
	}
	?>

	<!-- main -->
	<main id="main" <?php starck_main_class('main'); ?> role="main">

		<?php 
		$header_setting = starck_get_option( 'content_header_setting' );
		if ( 'disabled' !== $header_setting ) {
			global $post;
			$header_attr = '';
			$main_header_background = starck_get_option( 'content_header_background' );
			//$main_header_gallery = starck_get_option( 'content_header_gallery' );
			$gallery = get_post_meta( $post->ID, 'gallery-image' );

			if ( $main_header_background && count($gallery) < 2 ) {
				$header_attr = sprintf('class="header-background" style="background-image: url(%s)"', $main_header_background);
				?>
				<script type="text/javascript">
					$(window).scroll(function(){
						// preset parallax for header background
						$('.header-background').bgParallax({
							speed: 0.25,
						});
					});
				</script>
				<?php
			} 


			if ( ( 'front-page' == $header_setting && ( is_home() || is_front_page() ) ) || 
				 ('all-pages' == $header_setting && ( is_home() || is_front_page() || is_single() || is_page() || is_archive() ) ) ) {

				?>  
				<header id="main-header" <?php echo $header_attr; ?>>
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
							function create() {
								$('.jcarousel').jcarousel({
									wrap: 'circular',
									animation:   800,
									//transitions: true,

								});
							}

							$(function() {
								create();
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
			}
		}
		?>
		<!-- main container -->
		<div id="main-container" class="container">
