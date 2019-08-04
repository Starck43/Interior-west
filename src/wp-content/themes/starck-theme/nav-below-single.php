<?php $args = array(
	'prev_text' => '<span class="meta-nav">&larr;</span> %title',
	'next_text' => '%title <span class="meta-nav">&rarr;</span>'
); ?>
<nav id="single-post-nav">
	<?php the_post_navigation( $args ); ?>
</nav>