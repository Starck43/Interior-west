		</div>
	<!-- end main container -->
	<?php starck_back_to_previous_page(); ?>

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

		<?php 
		
		starck_back_to_top();

		wp_footer();
		
		?>
		
		<?php //Для отслеживания запросов к БД в режиме администратора
		if (current_user_can('administrator')){
			global $wpdb;
			echo "<pre>";
			print_r($wpdb->queries);
			echo "</pre>";
		}
		?>
	</footer>

<!-- 	<div id="site-search-modal" class="hidden">
	<?php 
	//get_search_form(); 
	?>
</div> -->

</body>
</html>