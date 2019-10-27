<article class="overview post-<?php the_ID(); ?> row" <?php post_class(); ?>>

	<?php
	if ( has_post_thumbnail() ) {
		?>
		<div class="cell col-sm-12 col-md-6">
			<?php the_post_thumbnail('large','class=lazyload'); ?>
		</div>
		<?php 
	}
	?>
	<div class="cell col-sm-12 col-md-6">
		<header class="overview-header">
			<?php the_title('<h2 class="entry-title">', '</h2>'); ?> 
		</header>
		<div class="entry-description">
			<?php the_content(); ?>
		</div>
	</div>

	<?php edit_post_link(); ?>

</article>