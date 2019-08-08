<aside id="main-sidebar" <?php starck_sidebar_class(); ?>>

<?php if ( ! is_active_sidebar( 'sidebar' ) ) { return; } ?>

	<div id="primary" class="widget-area">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</div>

</aside>
