		</div>
	<!-- end container -->
	</main>
	<!-- end main -->
	<footer id="site-footer"  <?php starck_footer_class(); ?> >
		<!-- container -->
		<div id="container" <?php echo "class=" . starck_get_option( 'footer_bound_setting' ); ?>>
			<?php wp_footer(); ?>

			<div id="copyright">
			&copy; <?php echo esc_html( date_i18n( __( 'Y', 'starck' ) ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			<?php //echo date( 'Y' ) /* выводим текущий год - альтернатива*/ ?>
			</div>
		</div>
		<!-- end container -->
	</footer>

</body>
</html>