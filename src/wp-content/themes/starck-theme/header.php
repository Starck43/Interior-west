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

	<header id="header"  <?php starck_add_classes('header'); ?>>
		<?php
		$custom_header = get_custom_header();
		if ( ! empty( $custom_header->attachment_id ) ) {
			?>
			<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
			<?php
		}
		?>
		<section id="site-header">
			<?php
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			if ( $custom_logo_id ) {
			?>
			<!-- logo -->
            <div id="header-logo" class="site-logo">
				<?php the_custom_logo(); ?>
            </div>
			<?php
			}
			?>
			<!-- header title -->
			<div id="header-title" class="site-title">
				<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1>'; } ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
				<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; } ?>
				<div class="site-description"><?php bloginfo( 'description' ); ?></div>
			</div>
		</section>
		
		<div id="site-search"><?php get_search_form(); ?></div>
		<nav id="site-menu">
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		</nav>

	</header>
	<!-- main -->
	<main id="main" <?php starck_add_classes('main'); ?> >

		<header id="main-header">
		</header>
		<!-- container -->
		<div id="container" <?php starck_add_classes( 'container' ); ?> >