
	<?php 
	if ( has_post_thumbnail() ) {
		$columns = 'col-6';
		?>
		<a class="<?php echo $columns ?>" href="<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', false ); echo esc_url( $src[0] ); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium','class=lazyload'); ?></a>
	<?php 
	} else $columns = 'col-auto';
	?>

	<div class="content-description <?php echo $columns ?>">
		<?php the_content(); ?>
	</div>

	<div class="entry-links"><?php wp_link_pages(); ?></div>
