<?php

/*
 * This template is for displaying all posts for each category separately
 *
 * @package Starck-theme 

   Template Name: Overview Post Template
   Template Post Type: page
 */
?>

<?php get_header(); ?>


	<?php		
	while (have_posts() ) : the_post();
		get_template_part( 'entry' );
	endwhile;
	?>

	<section id="overview-page">
		<?php
		$categories = get_categories( array(
			'taxonomy'     => 'category',
			'child_of'     => 0,
			'parent'       => '',
			'orderby'      => 'term_group',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'exclude'      => '',
			'include'      => '',
			'pad_counts'   => false,
			// полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
		) );
		foreach ($categories as $cat) {
			echo '<header class="entry-header"><h1 class="entry-title">'.$cat->name.'</h1></header>';
			$args = array(
				'category_name' => $cat->slug,
				//'posts_per_page' => 5,
			);
			$loop = new WP_Query($args);

			while ( $loop->have_posts() ) : $loop->the_post();
				get_template_part( 'entry','overview' );
			endwhile;
			wp_reset_postdata();
		}
		?>
		
	</section>

<?php get_footer(); ?>