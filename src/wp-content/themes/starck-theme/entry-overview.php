<article class="entry overview row post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	if ( has_post_thumbnail() ) {
		?>
		<section class="cell col-sm-12 col-md-6">
			<?php the_post_thumbnail('large','class=lazyload'); ?>
		</section>
		<?php 
	}
	?>
	<section class="cell col-sm-12 col-md-6">
		<header class="entry-header">
			<?php the_title('<h2 class="entry-title">', '</h2>'); ?> 
		</header>
		<div class="entry-description">
			<?php the_content(); ?>
		</div>
	</section>

	<?php edit_post_link(); ?>

</article>