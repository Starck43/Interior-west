<aside id="main-sidebar">

<?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
<div id="primary" class="widget-area">
<section class="widget-element">
<?php dynamic_sidebar( 'primary-widget-area' ); ?>
</section>
</div>
<?php endif; ?>

</aside>