		</div>
	<!-- end main container -->
		<div id="site-search-modal"><?php get_search_form(); ?></div>
	</main>
	<!-- end main -->

	<footer id="site-footer"  <?php starck_footer_class('site-footer'); ?> >
		<!-- container -->
		<div id="footer-container">
			<?php

			$widgets = (int)starck_get_option( 'footer_widget_setting' );

			if ( $widgets > 0 ) {
				starck_get_footer_widgets( $widgets );
			}
			?>

			<div id="copyright">
				&copy;
				<?php echo esc_html( date_i18n( __( 'Y', 'starck' ) ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) );
				// echo date( 'Y' ) /* выводим текущий год - альтернатива*/
				?>
			</div>
		</div>
		<!-- end container -->

		<?php wp_footer(); ?>

	</footer>
	<div id="overlay" class="modal hidden"></div>
	<?php starck_back_to_top(); ?>
</body>
</html>