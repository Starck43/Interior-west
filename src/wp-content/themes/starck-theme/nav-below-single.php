<?php $args = array(
	'screen_reader_text' => __('Navigation','starck'),
	'prev_text' => '<span class="meta-nav"><svg class="icon arrow-icon left"><use xlink:href="#arrow"></use></span> %title',
	'next_text' => '%title <span class="meta-nav"><svg class="icon arrow-icon right"><use xlink:href="#arrow"></use></span>',
); ?>
<nav id="single-post-nav">
	<?php the_post_navigation( $args ); ?>
</nav>