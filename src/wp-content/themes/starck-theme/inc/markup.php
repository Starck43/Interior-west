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
 * Display HTML classes for an element.
 *
 * @param string $context The element we're targeting.
 * @param string|array $class One or more classes to add to the class list.
 */
function starck_add_classes( $context, $class = '' ) {
	echo 'class="' . join( ' ', starck_get_element_classes( $context, $class ) ) . '"'; // WPCS: XSS ok, sanitization ok.
}

/**
 * Retrieve HTML classes for an element.
 *
 * @param string $context The element we're targeting.
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function starck_get_element_classes( $context, $class = '' ) {
	$classes = array();

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		// Соединяем классы, если есть второй параметр
		$classes = array_merge( $classes, $class );
	}

	$classes = array_map( 'esc_attr', $classes );

	return apply_filters( "starck_{$context}_class", $classes, $class );
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

if ( ! function_exists( 'starck_top_bar_classes' ) ) {
	add_filter( 'starck_top_bar_class', 'starck_top_bar_classes' );
	/**
	 * Adds custom classes to the header.
	 *
	 * @since 0.1
	 */
	function starck_top_bar_classes( $classes ) {
		$classes[] = 'top-bar';

		if ( 'contained' === starck_get_option( 'top_bar_width' ) ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		$classes[] = 'top-bar-align-' . esc_attr( starck_get_option( 'top_bar_alignment' ) );

		return $classes;
	}
}

if ( ! function_exists( 'starck_sidebar_classes' ) ) {
	add_filter( 'starck_sidebar_class', 'starck_sidebar_classes' );
	/**
	 * Adds custom classes to the right sidebar.
	 */
	function starck_sidebar_classes( $classes ) {

		// Get the layout sidebar
		$sidebar_layout = starck_get_layout();

		$classes[] = $sidebar_layout;
		//$classes[] = 'widget-area';



		return $classes;
	}
}


if ( ! function_exists( 'starck_content_classes' ) ) {
	add_filter( 'starck_content_class', 'starck_content_classes' );
	/**
	 * Adds custom classes to the content container.
	 */
	function starck_content_classes( $classes ) {

		$classes[] = 'content';


		// Get the layout
		$sidebar_layout = starck_get_layout();

		if ( '' !== $sidebar_layout ) {
			switch ( $sidebar_layout ) {

				case 'right-sidebar' :
					$classes[] = 'left-content';
				break;

				case 'left-sidebar' :
					$classes[] = 'right-content';
				break;

				case 'no-sidebar' :
				break;

			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'starck_header_classes' ) ) {
	add_filter( 'starck_header_class', 'starck_header_classes' );
	/**
	 * Adds custom classes to the header.
	 */
	function starck_header_classes( $classes ) {
		$classes[] = 'site-header';

		$classes[] = starck_get_option( 'header_layout_setting' );

		return $classes;
	}
}

if ( ! function_exists( 'starck_inside_header_classes' ) ) {
	add_filter( 'starck_inside_header_class', 'starck_inside_header_classes' );
	/**
	 * Adds custom classes to inside the header.
	 */
	function starck_inside_header_classes( $classes ) {
		$classes[] = 'inside-header';

		$classes[] = starck_get_option( 'header_inner_width' );

		return $classes;
	}
}

if ( ! function_exists( 'starck_navigation_classes' ) ) {
	add_filter( 'starck_navigation_class', 'starck_navigation_classes' );
	/**
	 * Adds custom classes to the navigation.
	 
	 
	 */
	function starck_navigation_classes( $classes ) {
		$classes[] = 'main-navigation';

		$classes[] = starck_get_option( 'nav_layout_setting' );

		if ( 'left' === starck_get_option( 'nav_dropdown_direction' ) ) {
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

		return $classes;
	}
}

if ( ! function_exists( 'starck_inside_navigation_classes' ) ) {
	add_filter( 'starck_inside_navigation_class', 'starck_inside_navigation_classes' );
	/**
	 * Adds custom classes to the inner navigation.
	 *
	 * @since 1.3.41
	 */
	function starck_inside_navigation_classes( $classes ) {
		$classes[] = 'inside-navigation';

		if ( 'full-width' !== starck_get_option( 'nav_inner_width' ) ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;
	}
}

if ( ! function_exists( 'starck_menu_classes' ) ) {
	add_filter( 'starck_menu_class', 'starck_menu_classes' );
	/**
	 * Adds custom classes to the menu.
	 *
	 * @since 0.1
	 */
	function starck_menu_classes( $classes ) {
		$classes[] = 'menu';
		$classes[] = 'sf-menu';

		return $classes;
	}
}

if ( ! function_exists( 'starck_footer_classes' ) ) {
	add_filter( 'starck_footer_class', 'starck_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 * @since 0.1
	 */
	function starck_footer_classes( $classes ) {
		$classes[] = 'site-footer';

		if ( 'contained-footer' === starck_get_option( 'footer_layout_setting' ) ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		if ( is_active_sidebar( 'footer-bar' ) ) {
			$classes[] = 'footer-bar-active';
			$classes[] = 'footer-bar-align-' . esc_attr( starck_get_option( 'footer_bar_alignment' ) );
		}

		return $classes;
	}
}

if ( ! function_exists( 'starck_inside_footer_classes' ) ) {
	add_filter( 'starck_inside_footer_class', 'starck_inside_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 * @since 0.1
	 */
	function starck_inside_footer_classes( $classes ) {
		$classes[] = 'footer-widgets-container';

		if ( 'full-width' !== starck_get_option( 'footer_inner_width' ) ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;
	}
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
