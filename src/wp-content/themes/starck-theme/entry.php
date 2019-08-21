<article class="entry post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php 
		if (get_post_meta( $post->ID, 'hide-title', true )) $hidden_class = ' hidden';

		if ( is_singular() ) {
			echo '<h1 class="entry-title' . $hidden_class . '">';
		} else {
			echo '<h2 class="entry-title' . $hidden_class . '">';
		}
		?>

		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
		<?php if ( is_singular() ) {
			echo '</h1>';
		} else {
			echo '</h2>';
		} 
		?>

	</header>

	<?php edit_post_link(); ?>
	<?php if ( ! is_search() ) { get_template_part( 'entry', 'meta' ); } ?>

	<?php get_template_part( 'entry', ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
	<?php if ( is_singular() ) { get_template_part( 'entry-footer' ); } ?>

</article>