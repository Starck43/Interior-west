<article class="entry post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php
		$header_class = ' class="entry-title' . ((get_post_meta( $post->ID, 'hide-title', true )) ? ' hidden' : '');

		if ( is_singular() ) :
			the_title( '<h1' . $header_class . '">', '</h1>' );
		else :
			the_title( sprintf( '<h2' . $header_class . '"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;

		?>

	</header>

	<?php
	if ( is_singular() ) {
		the_content();
	}
	else {
	?>
	<div class="entry-content">
		<?php

		get_template_part( 'entry', ( is_archive() || is_search() ? 'summary' : 'content' ) );
		?>
		<?php if ( is_user_admin() ) edit_post_link(); ?>
	</div>
	<?php } ?>

</article>