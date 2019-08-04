<?php
/**
 * Builds our Customizer controls.
 *
 * @package starck
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_action( 'customize_register', 'starck_set_customizer_helpers', 1 );
function starck_set_customizer_helpers() {
	require_once trailingslashit( get_template_directory() ) . 'inc/customizer-helpers.php';
}

if ( ! function_exists( 'starck_customize_register' ) ) {
	add_action( 'customize_register', 'starck_customize_register' );
	/**
	 * Add our base options to the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function starck_customize_register( $wp_customize ) {
		$defaults = starck_get_defaults();

		require_once trailingslashit( get_template_directory() ) . 'inc/customizer-helpers.php';


		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Starck_Customize_Misc_Control' );
			$wp_customize->register_control_type( 'Starck_Range_Slider_Control' );
		}

		if ( method_exists( $wp_customize, 'register_section_type' ) ) {
			$wp_customize->register_section_type( 'Starck_Upsell_Section' );
		}

/*
 * Examples
 *
				'transport'   => 'postMessage' // 'postMessage' - асинхронным запросом с применением JavaScript, 'refresh' - перезагрузкой фрейма без использования JS
 				'section'    => 'colors', // Стандартная секция - Цвета
				'type'      => 'theme_mod', // использовать get_theme_mod() для получения настроек
				'type'      => 'option', // нужно будет использовать функцию get_option() для получения настроек
				'type'     => 'text' // текстовое поле
				'type'     => 'select', // выпадающий список select
				'type'      => 'checkbox' // тип - чекбокс
				'type'     => 'radio', // радио-кнопки
				'choices'  => array( // все значения радио-кнопок
				'normal'    => 'Светлая', // перечисляем в виде массива
				'inverse'   => 'Темная'
				'sanitize_callback'  => 'true_sanitize_copyright', // функция, обрабатывающая значение поля при сохранении
				
			Default Controls:
				WP_Customize_Image_Control
				WP_Customize_Color_Control
				WP_Customize_Media_Control
				WP_Customize_Nav_Menu_Control
				
			)
 *
 */
		// Создаем панель в настройках темы
		if ( class_exists( 'WP_Customize_Panel' ) ) {
			if ( ! $wp_customize->get_panel( 'starck_layout_panel' ) ) {
				$wp_customize->add_panel( 'starck_layout_panel', array(
					'priority' => 25,
					'title' => __( 'Layout', 'starck' ), //Настройки - Макет
				) );
			}
		}
		
// Layout container
		$wp_customize->add_section(
			'starck_layout_container',
			array(
				'title' =>  __( 'Container', 'starck' ),
				'priority' => 10,
				'panel' => 'starck_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'starck_settings[container_width]', // section id
			array(
				'default' => $defaults['container_width'],
				'type' => 'option',
				'sanitize_callback' => 'starck_sanitize_integer',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Starck_Range_Slider_Control(
				$wp_customize,
				'starck_settings[container_width]', // section id
				array(
					'type' => 'starck-range-slider',
					'label' =>  __( 'Container Width', 'starck' ),
					'section' => 'starck_layout_container',
					'settings' => array(
						'desktop' => 'starck_settings[container_width]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 900,
							'max' => 1920,
							'step' => 50,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'priority' => 0,
				)
			)
		);

		
// Sidebar
		$wp_customize->add_section(
			'starck_layout_sidebars',
			array(
				'title' => __( 'Sidebars', 'starck' ),
				'priority' => 40,
				'panel' => 'starck_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'starck_settings[layout_setting]',
			array(
				'default' => $defaults['layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'starck_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'starck_settings[layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Sidebar Layout', 'starck' ),
				'section' => 'starck_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'starck' ),
					'right-sidebar' => __( 'Content / Sidebar', 'starck' ),
					//'sidebar' => __( 'Sidebar / Content', 'starck' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'starck' ),
				),
				'settings' => 'starck_settings[layout_setting]',
				'priority' => 30,
			)
		);

		$wp_customize->add_setting(
			'starck_settings[blog_layout_setting]',
			array(
				'default' => $defaults['blog_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'starck_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'starck_settings[blog_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Blog Sidebar Layout', 'starck' ),
				'section' => 'starck_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'starck' ),
					'right-sidebar' => __( 'Content / Sidebar', 'starck' ),
					//'sidebar' => __( 'Sidebar / Content', 'starck' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'starck' ),
				),
				'settings' => 'starck_settings[blog_layout_setting]',
				'priority' => 35,
			)
		);
//
		$wp_customize->add_setting(
			'starck_settings[single_layout_setting]',
			array(
				'default' => $defaults['single_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'starck_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'starck_settings[single_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Single Post Sidebar Layout', 'starck' ),
				'section' => 'starck_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'starck' ),
					'right-sidebar' => __( 'Content / Sidebar', 'starck' ),
					//'sidebar' => __( 'Sidebar / Content', 'starck' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'starck' ),
				),
				'settings' => 'starck_settings[single_layout_setting]',
				'priority' => 36,
			)
		);
		
// Footer
		$wp_customize->add_section(
			'starck_layout_footer',
			array(
				'title' => __( 'Footer', 'starck' ),
				'priority' => 50,
				'panel' => 'starck_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'starck_settings[footer_widget_setting]',
			array(
				'default' => $defaults['footer_widget_setting'],
				'type' => 'option',
				'sanitize_callback' => 'starck_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'starck_settings[footer_widget_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Widgets', 'starck' ),
				'section' => 'starck_layout_footer',
				'choices' => array(
					'0' =>  __( 'Disable', 'starck' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',

				),
				'settings' => 'starck_settings[footer_widget_setting]',
				'priority' => 45,
			)
		);

		$wp_customize->add_setting(
			'starck_settings[footer_bar_alignment]',
			array(
				'default' => $defaults['footer_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'starck_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'starck_settings[footer_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Bar Alignment', 'starck' ),
				'section' => 'starck_layout_footer',
				'choices' => array(
					'left' => __( 'Left','starck' ),
					'center' => __( 'Center','starck' ),
					'right' => __( 'Right','starck' ),
				),
				'settings' => 'starck_settings[footer_bar_alignment]',
				'priority' => 46,
				//'active_callback' => 'starck_is_footer_bar_active',
			)
		);

		$wp_customize->add_setting(
			'starck_settings[back_to_top]',
			array(
				'default' => $defaults['back_to_top'],
				'type' => 'option',
				'sanitize_callback' => 'starck_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'starck_settings[back_to_top]',
			array(
				'type' => 'select',
				'label' => __( 'Back to Top Button', 'starck' ),
				'section' => 'starck_layout_footer',
				'choices' => array(
					'enable' => __( 'Enable', 'starck' ),
					'' => __( 'Disable', 'starck' ),
				),
				'settings' => 'starck_settings[back_to_top]',
				'priority' => 50,
			)
		);

	}
}
