<?php
/**
 * Helper functions for the Customizer.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'starck_is_posts_page' ) ) {
	/**
	 * Check to see if we're on a posts page
	 *
	 * @since 1.3.39
	 */
	function starck_is_posts_page() {
		return ( is_home() || is_archive() || is_tax() ) ? true : false;
	}
}

if ( ! function_exists( 'starck_is_footer_bar_active' ) ) {
	/**
	 * Check to see if we're using our footer bar widget
	 *
	 * @since 1.3.42
	 */
	function starck_is_footer_bar_active() {
		return ( is_active_sidebar( 'footer-bar' ) ) ? true : false;
	}
}

if ( ! function_exists( 'starck_is_top_bar_active' ) ) {
	/**
	 * Check to see if the top bar is active
	 *
	 * @since 1.3.45
	 */
	function starck_is_top_bar_active() {
		$top_bar = is_active_sidebar( 'top-bar' ) ? true : false;
		return apply_filters( 'starck_is_top_bar_active', $top_bar );
	}
}

if ( ! function_exists( 'starck_hidden_navigation' ) && function_exists( 'is_customize_preview' ) ) {
	add_action( 'wp_footer', 'starck_hidden_navigation' );
	/**
	 * Adds a hidden navigation if no navigation is set
	 * This allows us to use postMessage to position the navigation when it doesn't exist
	 *
	 * @since 1.3.40
	 */
	function starck_hidden_navigation() {
		if ( is_customize_preview() && function_exists( 'starck_navigation_position' ) ) {
			?>
			<div style="display:none;">
				<?php starck_navigation_position(); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'starck_customize_partial_blogname' ) ) {
	/**
	 * Render the site title for the selective refresh partial.
	 *
	 * @since 1.3.41
	 */
	function starck_customize_partial_blogname() {
		bloginfo( 'name' );
	}
}

if ( ! function_exists( 'starck_customize_partial_blogdescription' ) ) {
	/**
	 * Render the site tagline for the selective refresh partial.
	 *
	 * @since 1.3.41
	 */
	function starck_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}

if ( ! function_exists( 'starck_enqueue_color_palettes' ) ) {
	add_action( 'customize_controls_enqueue_scripts', 'starck_enqueue_color_palettes' );
	/**
	 * Add our custom color palettes to the color pickers in the Customizer.
	 *
	 * @since 1.3.42
	 */
	function starck_enqueue_color_palettes() {
		// Old versions of WP don't get nice things
		if ( ! function_exists( 'wp_add_inline_script' ) ) {
			return;
		}

		// Grab our palette array and turn it into JS
		//$palettes = json_encode( starck_get_default_color_palettes() );

		// Add our custom palettes
		// json_encode takes care of escaping
		wp_add_inline_script( 'wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . $palettes . ';' );
	}
}

if ( ! function_exists( 'starck_sanitize_integer' ) ) {
	/**
	 * Sanitize integers.
	 *
	 * @since 1.0.8
	 */
	function starck_sanitize_integer( $input ) {
		return absint( $input );
	}
}

if ( ! function_exists( 'starck_sanitize_decimal_integer' ) ) {
	/**
	 * Sanitize integers that can use decimals.
	 *
	 * @since 1.3.41
	 */
	function starck_sanitize_decimal_integer( $input ) {
		return abs( floatval( $input ) );
	}
}

/**
 * Sanitize a positive number, but allow an empty value.
 *
 * @since 2.2
 */
function starck_sanitize_empty_absint( $input ) {
	if ( '' == $input ) {
		return '';
	}

	return absint( $input );
}

if ( ! function_exists( 'starck_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox values.
	 *
	 * @since 1.0.8
	 */
	function starck_sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

if ( ! function_exists( 'starck_sanitize_blog_excerpt' ) ) {
	/**
	 * Sanitize blog excerpt.
	 * Needed because GP Premium calls the control ID which is different from the settings ID.
	 *
	 * @since 1.0.8
	 */
	 function starck_sanitize_blog_excerpt( $input ) {
		 $valid = array(
			 'full',
			 'excerpt'
		 );

		 if ( in_array( $input, $valid ) ) {
			 return $input;
		 } else {
			 return 'full';
		 }
	 }
}

if ( ! function_exists( 'starck_sanitize_hex_color' ) ) {
	/**
	 * Sanitize colors.
	 * Allow blank value.
	 *
	 * @since 1.2.9.6
	 */
	 function starck_sanitize_hex_color( $color ) {
		 if ( '' === $color ) {
			 return '';
		 }

		 // 3 or 6 hex digits, or the empty string.
		 if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			 return $color;
		 }

		 return '';
	 }
}

/**
 * Sanitize RGBA colors.
 *
 * @since 2.2
 */
function starck_sanitize_rgba_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	if ( false === strpos( $color, 'rgba' ) ) {
		return starck_sanitize_hex_color( $color );
	}

	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

	return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
}

if ( ! function_exists( 'starck_sanitize_choices' ) ) {
	/**
	 * Sanitize choices.
	 *
	 * @since 1.3.24
	 */
	function starck_sanitize_choices( $input, $setting ) {
		// Ensure input is a slug
		$input = sanitize_key( $input );

		// Get list of choices from the control
		// associated with the setting
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it;
		// otherwise, return the default
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

/**
 * Sanitize our Google Font variants
 *
 * @since 2.0
 */
function starck_sanitize_variants( $input ) {
	if ( is_array( $input ) ) {
		$input = implode( ',', $input );
	}
	return sanitize_text_field( $input );
}

add_action( 'customize_controls_enqueue_scripts', 'starck_do_control_inline_scripts', 100 );
/**
 * Add misc inline scripts to our controls.
 *
 * We don't want to add these to the controls themselves, as they will be repeated
 * each time the control is initialized.
 *
 * @since 2.0
 */
function starck_do_control_inline_scripts() {
	wp_localize_script( 'starck-typography-customizer', 'gp_customize',
		array(
			'nonce' => wp_create_nonce( 'gp_customize_nonce' )
		)
	);

	wp_localize_script( 'starck-typography-customizer', 'typography_defaults', starck_typography_default_fonts() );

	wp_enqueue_script( 'starck-customizer-controls', trailingslashit( get_template_directory_uri() ) . 'inc/controls/js/customizer-controls.js', array( 'customize-controls', 'jquery' ), STARCK_VERSION, true );
	wp_localize_script( 'starck-customizer-controls', 'starck_defaults', starck_get_defaults() );
	//wp_localize_script( 'starck-customizer-controls', 'starck_color_defaults', starck_get_color_defaults() );
}

if ( ! function_exists( 'starck_customizer_live_preview' ) ) {
	add_action( 'customize_preview_init', 'starck_customizer_live_preview', 100 );
	/**
	 * Add custom live preview scripts
	 */
	function starck_customizer_live_preview() {
		$spacing_settings = wp_parse_args(
			get_option( 'starck_spacing_settings', array() ),
			starck_spacing_get_defaults()
		);

		wp_enqueue_script( 'starck-themecustomizer', trailingslashit( get_template_directory_uri() ) . 'inc/controls/js/customizer-live-preview.js', array( 'customize-preview' ), STARCK_VERSION, true );

		wp_localize_script( 'starck-themecustomizer', 'starck_live_preview', array(
			'mobile' => apply_filters( 'starck_mobile_media_query', '(max-width:768px)' ),
			'tablet' => apply_filters( 'starck_tablet_media_query', '(min-width: 769px) and (max-width: 1024px)' ),
			'desktop' => apply_filters( 'starck_desktop_media_query', '(min-width:1025px)' ),
			'contentLeft' => absint( $spacing_settings['content_left'] ),
			'contentRight' => absint( $spacing_settings['content_right'] ),
		) );
	}
}

/**
 * Check to see if we have a logo or not.
 *
 * Used as an active callback. Calling has_custom_logo creates a PHP notice for
 * multisite users.
 *
 * @since 2.0.1
 */
function starck_has_custom_logo_callback() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		return true;
	}

	return false;
}

/**
 * Save our preset layout controls. These should always save to be "current".
 *
 * @since 2.2
 */
function starck_sanitize_preset_layout( $input ) {
	return 'current';
}
