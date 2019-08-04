	</div>
	<!-- end container -->
	
	<footer id="site-footer">

		<?php wp_footer(); ?>

		<div id="copyright">
		&copy; <?php echo esc_html( date_i18n( __( 'Y', 'starck' ) ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
		<?php //echo date( 'Y' ) /* выводим текущий год - альтернатива*/ ?>
		</div>

	</footer>

</body>
</html>