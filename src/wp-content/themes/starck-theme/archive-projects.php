<?php 
/*

 * The template for Projects portfolio
 *
 * @package Starck-theme 

   Template Name: Projects Portfolio
   Template Post Type: page
 */
global $post;

$content = $post->post_content;

get_header(); ?>

	<section id="content" <?php starck_content_class('projects'); ?>>
		<?php starck_breadcrumbs(); ?>

		<header class="projects-header">
			<h1 class="projects-title"><?php single_term_title(); ?></h1>
		</header>


		<?php
		/* Query the post */
		$args = array( 'post_type' => 'projects', 'posts_per_page' => -1 );//this will return ALL of the posts from the projects CPT. You can also change this to a specific number such as 'posts_per_page' => 10... 
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
		?>
		<article class="entry post-<?php the_ID(); ?>" <?php post_class(); ?>>		
			<a href="<?php echo get_permalink($post->ID) ?>"><?php the_post_thumbnail(); ?></a> <!-- This returns the featured image with it linked to the page that it was added to-->
			<h4><?php the_title(); ?></h4>
			<p><?php the_excerpt(); ?></p>
		</article>
		<?php endwhile; ?> 
		<?php get_template_part( 'nav', 'below' );

		?>

	</section>


<?php get_footer(); ?>