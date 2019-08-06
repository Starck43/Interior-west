<?php
/**
 * Adds HTML markup.
 *
 * @package Starcktheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**

 */
function starck_merge_classes( $classes, $merged_class = '' ) {

	if ( ! empty( $merged_class ) ) {
		if ( ! is_array( $merged_class ) ) {
			$merged_class = preg_split( '#\s+#', $merged_class );
		}
		// Соединяем классы, если есть второй параметр
		$classes = array_merge( $classes, $merged_class );
	}
	// Apply esc_attr() function to array $classes
	$classes = array_map( 'esc_attr', $classes );

	if ($classes) { echo 'class="' . join( ' ', $classes ) . '"'; };

}


if ( ! function_exists( 'starck_post_classes' ) ) {

	add_filter( 'post_class', 'starck_post_classes' );
	/**
	 * Adds custom classes to the <article> element.
	 * Remove .hentry class from pages to comply with structural data guidelines.
	 *
	 * @since 1.3.39
	 */
	function starck_post_classes( $classes ) {

		if ( 'page' == get_post_type() ) {
			$classes = array_diff( $classes, array( 'hentry' ) );
		}

		return $classes;
	}
}


if ( ! function_exists( 'starck_body_classes' ) ) {
	add_filter( 'body_class', 'starck_body_classes' );
	/**
	 * Adds custom classes to the array of body classes.
	 
	 
	 */
	function starck_body_classes( $classes ) {

		$sidebar_layout 		= starck_get_layout();
		//$navigation_location 	= starck_get_navigation_location();
		//$navigation_alignment	= starck_get_option( 'nav_alignment_setting' );
		//$navigation_dropdown	= starck_get_option( 'nav_dropdown_type' );
		//$header_layout 			= starck_get_option( 'header_layout_setting' );
		//$header_alignment		= starck_get_option( 'header_alignment_setting' );
		//$content_layout 		= starck_get_option( 'content_layout_setting' ); //????
		$footer_widgets 		= starck_get_footer_widgets();

		// These values all have defaults, but we like to be extra careful.
		$classes[] = ( $sidebar_layout ) ? $sidebar_layout : 'no-sidebar';
		$classes[] = ( $navigation_location ) ? $navigation_location : 'nav-below-header';
		//$classes[] = ( $header_layout ) ? $header_layout : 'fluid-header';
		//$classes[] = ( $content_layout ) ? $content_layout : 'separate-containers';
		$classes[] = ( '' !== $footer_widgets ) ? 'active-footer-widgets-' . absint( $footer_widgets ) : 'active-footer-widgets-1';

		if ( 'enable' === starck_get_option( 'nav_search' ) ) { //вывод кнопки 'поиск' в верхнее меню
			$classes[] = 'nav-search-enabled';
		}

		// Only necessary for nav before or after header.
		if ( 'nav-below-header' === $navigation_location || 'nav-above-header' === $navigation_location ) {
			if ( 'center' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-center';
			} elseif ( 'right' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-right';
			} elseif ( 'left' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-left';
			}
		}

		if ( 'center' === $header_alignment ) {
			$classes[] = 'header-aligned-center';
		} elseif ( 'right' === $header_alignment ) {
			$classes[] = 'header-aligned-right';
		} elseif ( 'left' === $header_alignment ) {
			$classes[] = 'header-aligned-left';
		}

		if ( is_singular() ) {
			// Content container metabox option.
			// Used to be a single checkbox. Now it's a radio choice between full width and contained.
			$content_container = get_post_meta( get_the_ID(), '_full-width-content', true );

			if ( $content_container ) {
				if ( 'true' === $content_container ) {
					$classes[] = 'full-width';
				}

				if ( 'contained' === $content_container ) {
					$classes[] = 'contained';
				}
			}

			if ( has_post_thumbnail() ) {
				$classes[] = 'featured-image-active';
			}
		}

		return $classes;
	}
}


if ( ! function_exists( 'starck_header_classes' ) ) {
	add_filter( 'starck_add_header_class', 'starck_header_classes' );
	/**
	 * Adds custom classes to the header.
	 */
	function starck_header_classes( $merged_class ) {
		$classes[] = 'header';

		$classes[] = starck_get_option( 'header_bound_setting' );
		$classes[] = 'align-' . esc_attr( starck_get_option( 'header_alignment' ) );

		return starck_merge_classes($classes, $merged_class);
	}
}


if ( ! function_exists( 'starck_main_classes' ) ) {
	add_filter( 'starck_add_main_class', 'starck_main_classes' );
	/**
	 * Adds custom classes to the header.
	 */
	function starck_main_classes( $merged_class ) {
		$classes[] = 'main';

		$classes[] = starck_get_option( 'main_bound_setting' ); //'bounded', 'wide-full'
		//$classes[] = starck_get_option( 'header_layout_setting' );

		return starck_merge_classes($classes, $merged_class);
	}
}


if ( ! function_exists( 'starck_navigation_classes' ) ) {
	add_filter( 'starck_add_navigation_class', 'starck_navigation_classes' );
	/**
	 * Adds custom classes to the navigation.
	 
	 
	 */
	function starck_navigation_classes( $merged_class ) {
		$classes[] = 'main-menu';

		$classes[] = starck_get_option( 'nav_bound_setting' );
		//$classes[] = starck_get_option( 'nav_layout_setting' );

		if ( 'left' === starck_get_option( 'menu_appearence_direction' ) ) {
			$nav_layout = starck_get_option( 'nav_position_setting' );

			switch ( $nav_layout ) {
				case 'nav-below-header':
				case 'nav-above-header':
				case 'nav-float-right':
				case 'nav-float-left':
					$classes[] = 'sub-menu-left';
				break;
			}
		}

		return starck_merge_classes($classes, $merged_class);
	}
}



if ( ! function_exists( 'starck_content_classes' ) ) {
	add_filter( 'starck_add_content_class', 'starck_content_classes' );
	/**
	 * Adds custom classes to the content container.
	 */
	function starck_content_classes( $merged_class ) {

		$classes[] = 'main-content';

		// Get the sidebar layout
		$classes[] = starck_get_layout();

		return starck_merge_classes($classes, $merged_class);
	}
}


if ( ! function_exists( 'starck_sidebar_classes' ) ) {
	add_filter( 'starck_add_sidebar_class', 'starck_sidebar_classes' );
	/**
	 * Adds custom classes to the right sidebar.
	 */
	function starck_sidebar_classes( $merged_class ) {
		
		$classes[] = 'main-sidebar';

		return starck_merge_classes($classes, $merged_class);
	}
}


if ( ! function_exists( 'starck_footer_classes' ) ) {
	add_filter( 'starck_add_footer_class', 'starck_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 */
	function starck_footer_classes( $merged_class ) {
		$classes[] = 'site-footer';

		$classes[] = starck_get_option( 'footer_bound_setting' );
		//$classes[] = starck_get_option( 'footer_layout_setting' );

		if ( '1' === starck_get_option( 'footer_widget_setting' ) ) {
			$classes[] = 'align-' . esc_attr( starck_get_option( 'footer_alignment' ) );
		}

		return starck_merge_classes($classes, $merged_class);
	}
}