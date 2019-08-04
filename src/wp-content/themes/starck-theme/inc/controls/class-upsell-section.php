<?php
/**
 * The upsell Customizer section.
 *
 * @package Starcktheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Starck_Upsell_Section' ) ) {
	/**
	 * Create our upsell section.
	 * Escape your URL in the Customizer using esc_url().
	 *
	 * @since unknown
	 */
	class Starck_Upsell_Section extends WP_Customize_Section {
		public $type = 'gp-upsell-section';
		public $pro_url = '';
		public $pro_text = '';
		public $id = '';

		public function json() {
			$json = parent::json();
			$json['pro_text'] = $this->pro_text;
			$json['pro_url']  = esc_url( $this->pro_url );
			$json['id'] = $this->id;
			return $json;
		}

		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="generate-upsell-accordion-section control-section-{{ data.type }} cannot-expand accordion-section">
				<h3><a href="{{{ data.pro_url }}}" target="_blank">{{ data.pro_text }}</a></h3>
			</li>
			<?php
		}
	}
}
/**
 * Add CSS for our controls
 */
if ( ! function_exists( 'Starck_customizer_controls_css' ) ) {
	add_action( 'customize_controls_enqueue_scripts', 'Starck_customizer_controls_css' );

	function Starck_customizer_controls_css() {
		wp_enqueue_style( 'starck-customizer-controls-css', trailingslashit( get_template_directory_uri() ) . 'inc/controls/css/upsell-customizer.css', array(), STARCK_VERSION );
		wp_enqueue_script( 'starck-upsell', trailingslashit( get_template_directory_uri() ) . 'inc/controls/js/upsell-control.js', array( 'customize-controls' ), false, true );
	}
}
