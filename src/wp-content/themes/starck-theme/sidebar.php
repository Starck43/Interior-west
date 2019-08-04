<aside id="main-sidebar" <?php starck_add_classes( 'sidebar' ); ?>>

<div id="primary" class="widget-area">
	<section class="widget-element">
		<?php 
		if ( ! dynamic_sidebar( 'right-sidebar' ) ) { //Если сайдбар отмечен в настройках темы и виджетов пока нет, то вывести для примера произвольные виджеты
			add_default_sidebar_widget( 'right-sidebar' );
		}
		?>
	</section>
</div>

</aside>
