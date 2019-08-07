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

	<header id="site-header" <?php starck_header_class(); ?>>

		<!-- container -->
		<div id="container" <?php echo "class=" . starck_get_option( 'header_bound_setting' ); ?>>
			<?php
			$custom_header = get_custom_header();
			if ( ! empty( $custom_header->attachment_id ) ) {
				?>
				<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
				<?php
			}
			?>
			<section id="branding" <?php starck_branding_class('branding'); ?>>
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
				<div id="branding-title" class="site-title">
					<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1>'; } ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
					<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; } ?>
					<div class="site-description"><?php bloginfo( 'description' ); ?></div>
				</div>
			</section>
			<section id="header-content" <?php echo 'class=align-' . ( "right" === starck_get_option( 'branding_alignment' ) ? 'left' : 'right') ?>>
			<?php
			if ( starck_get_option( 'header_search' ) && 'center' !== starck_get_option( 'branding_alignment' ) ) {	
			?>
				<div id="site-search" <?php starck_search_class(); ?>><?php get_search_form(); ?></div>
			<?php
			}

		if ( 'inline' !== starck_get_option( 'nav_position_setting' ) ) { 
		?>
		</section>
		</div>
		<!-- end container -->
		<?php
		}
		?>
			<nav id="site-menu" <?php starck_navigation_class(); ?> role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
			</nav>
		<?php 
		if ( 'inline' === starck_get_option( 'nav_position_setting' ) ) { 
		?>
		</section>
		</div>
		<!-- end container -->
		<?php
		}
		?>
	</header>

	<!-- main -->
	<main id="main" <?php starck_main_class(); ?> role="main">
		<!-- container -->
		<div id="container" <?php echo "class=" . starck_get_option( 'main_bound_setting' ); ?>>

			<header id="main-header">
			</header>