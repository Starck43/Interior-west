<?php
/**
 * Sets all of our theme defaults.
 *
 * @package Starcktheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'starck_get_defaults' ) ) {
	/**
	 * Set default options
	 *
	 */
	function starck_get_defaults() {
		return apply_filters( 'starck_option_defaults',
			array(
				'header_bound_setting' => 'full-width', //'bounded'
				'top_bar_layout_setting' => 'enabled', //'disabled'
				//'logo_width' => '',
				'branding_alignment' => 'left', //'left','center','right'
				'branding_vertical' => false,
				'header_search' => true,
				'nav_bound_setting' =>  'full-width', //'bounded'
				'nav_position_setting' => 'under', //'inline', 'above', 'under'
				'nav_alignment' => 'center', //'left', 'right'
				//'nav_search' => true,
				//'menu_appearence_action' => 'click', //'hover'
				//'menu_appearence_direction' => 'left', //'down'
				'main_bound_setting' => 'bounded', //full-width'
				'layout_setting' => 'right-sidebar',
				'blog_layout_setting' => 'right-sidebar',
				'single_layout_setting' => 'right-sidebar',
				'footer_bound_setting' => 'full-width', //'bounded'
				'footer_widget_setting' => '1',
				'footer_alignment' => 'center', //'left', 'right'
				'back_to_top' => true,

			)
		);
	}
}
