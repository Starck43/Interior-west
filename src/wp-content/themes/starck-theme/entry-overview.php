<article class="overview post-<?php the_ID(); ?> slide row" <?php post_class(); ?>>

	<?php
	if ( has_post_thumbnail() ) {
		?>
		<div class="overview-thumbnail cell col-sm-12 col-md-6">
			<?php the_post_thumbnail('medium','class=lazyload'); ?>
		</div>
		<?php
		$cell = 'cell col-sm-12 col-md-6';
	} else $cell = 'col-auto';
	?>
		<div class="overview-content <?php echo $cell; ?>">
			<header class="overview-header">
				<?php the_title('<h3 class="overview-title">','</h3>'); ?>
			</header>
			<div class="overview-description">
				<?php the_content(); ?>
			</div>
			<?php edit_post_link(); ?>
		</div>

</article>