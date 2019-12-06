
	<?php 
	if ( has_post_thumbnail() ) {
		?>
		<a class="entry-thumbnail col-md-5" href="<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', false ); echo esc_url( $src[0] ); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium','class=lazyload'); ?></a>
		<?php 
		$columns = 'col-md-7';
	} else $columns = 'col-auto';
	?>

	<div class="entry-description <?php echo $columns ?>">
		<?php the_content(); ?>
	</div>

	<div class="entry-links"><?php wp_link_pages(); ?></div>
