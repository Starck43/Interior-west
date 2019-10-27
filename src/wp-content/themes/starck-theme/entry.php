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

	<div class="entry-content row">
		<?php
		//if ( !is_search() ) get_template_part( 'entry', 'meta' );
		//get_template_part( 'entry', ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); 
		get_template_part( 'entry', ( is_archive() || is_search() ? 'summary' : 'content' ) );
		//if ( is_singular() ) get_template_part( 'entry', 'footer' );
		?>
	</div>

	<?php edit_post_link(); ?>

</article>