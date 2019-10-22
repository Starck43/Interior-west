<article class="preview-content post-<?php the_ID(); ?> row">
	<?php edit_post_link(); ?>

	<?php
	if ( has_post_thumbnail() ) {
		?>
		<section class="cell preview-img col-sm-12 col-md-6">
			<?php the_post_thumbnail('large','class=image'); ?>
		</section>
		<?php 
	}
	?>
	<section class="cell preview-description col-sm-12 col-md-6">
		<header class="entry-header">
			<?php the_title('<h1 class="cell-title">', '</h1>'); ?> 
		</header>
		<div class="cell-description">
			<?php the_content(); ?>
		</div>
	</section>

</article>