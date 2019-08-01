<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php esc_attr( bloginfo( 'charset' ) ); ?>" />
	<meta name="description" content="Starter web template for Wordpress">
	<meta name="viewport" content="width=device-width" />
	<link rel="icon" href="img/favicon.png">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<header id="site-header">

		<section id="site-header-container">
			<!-- logo -->
            <div id="header-logo" class="site-logo">
				<?php the_custom_logo(); ?>
            </div>
			<div id="header-title" class="site-title">
				<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1>'; } ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
				<?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; } ?>
				<div class="site-description"><?php bloginfo( 'description' ); ?></div>
			</div>
		</section>

		<div id="search"><?php get_search_form(); ?></div>
		<nav id="site-menu">
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		</nav>

	</header>