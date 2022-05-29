<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php esc_attr( bloginfo( 'charset' ) ); ?>" />
	<meta name="description" content="Разработка дизайна интерьера, архитектура малоэтажных домов, авторское сопровождение объекта по всей России">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" href="/img/favicon.png">
	<link rel="apple-touch-icon" href="/img/apple-touch-favicon.png">
	<meta name="yandex-verification" content="6099aebab02c2b27" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php include_once('sprite.svg'); ?>
	<!-- Preloader -->
	<div id="dom-preloader">
		<svg class="logo-icon"><use xlink:href="#logo"></use></svg>
	</div>
	<?php


	global $post;

	$custom_header = get_custom_header();
	$header_img_attr =  !empty( $custom_header->attachment_id ) ? sprintf(' style="background-image: url(%s)"', $custom_header->url) : '';
	?>

	<header id="site-header" <?php starck_header_class(['site-header', !empty( $custom_header->attachment_id ) ? 'header-background' : '']); echo $header_img_attr; ?>>

		<?php if ( 'enabled' === starck_get_option( 'top_bar_layout_setting' ) ) starck_get_top_bar(); ?>

		<!-- header-container -->
		<div id="header-container" class="<?php echo 'container branding-' . starck_get_option( 'branding_alignment' ); ?>">
			<?php
			$nav_position = starck_get_option( 'nav_position_setting' );
			if ( in_array($nav_position, ['above', 'below']) ) {
				// navigation
				starck_get_navigation();
			}
			?>
			<section id="branding" <?php starck_branding_class('site-branding'); ?>>
				<!-- logo -->
	            <div id="branding-logo" class="site-logo">
	            <?php
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					if ( $custom_logo_id ) {
						the_custom_logo();
					} else {
					?>
						<svg><use xlink:href="#logo"></use></svg>
					<?php
					}
				?>
	            </div>
				<?php

				// Get the title and tagline.
				//$title = get_bloginfo( 'title' );
				$description = get_bloginfo( 'description' );
				$title = explode("-", get_bloginfo( 'title' ));
				if ( !starck_get_option('hide_title') && '' != $title ) {
					?>
					<!-- header title -->
					<div id="branding-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'title' ) ); ?>" rel="home">
						<?php
							foreach ($title as $value)
								echo '<div>' . $value . '</div>';
						?></a>
						<?php if ( !starck_get_option('hide_description') && '' != $description ) { ?>
							<div class="site-description"><?php echo $description; ?></div>
						<?php } ?>
					</div>
					<?php
				}
				?>
			</section>

			<section id="header-content"  <?php printf('class="align-%1$s %2$s"',
													( "right" === starck_get_option( 'branding_alignment' ) ? 'left' : 'right'),
													( starck_get_option( 'nav_burger' ) ?  'burger-menu' : '' )
												); ?>>
				<?php
				if ( starck_get_option( 'header_widget_setting' ) )
					starck_get_header_widget();

				if ( 'inline' == $nav_position )
					starck_get_navigation();
				?>
			</section>
		</div>
		<!-- end header container -->
	</header>

	<?php
	if ( 'under' == $nav_position ) {
		starck_get_navigation();
	}
	?>

	<!-- main -->
	<main id="main" <?php starck_main_class(['main', $post ? get_post_type( $post->ID ) : 'search-result']); ?> role="main">

		<?php starck_breadcrumbs(); ?>

		<!-- main container -->
		<div id="main-container" class="container">

			<?php starck_main_header(); ?>
