<?php
/*
 * The single template for project
 *
 * @package Starck-theme 

   Template Name: Single Portfolio Template
   Template Post Type: post
 */
get_header();

global $post;

	?>
	<section id="content" <?php starck_content_class('project'); ?>>

		<?php starck_breadcrumbs(); ?>

		<?php while ( have_posts() ) : the_post();
		$gallery = get_post_meta( $post->ID, 'gallery-image' );
		if ($gallery) {
			the_content();
			?>
			<div class="gallery-wrapper">
				<div id="gallery">
					<?php 
					foreach ($gallery as $value) {
						$image = wp_get_attachment_image_src( absint($value), 'medium' );
						$full_image = wp_get_attachment_image_url( absint($value), 'full' );
						?>
						<img src="<?php echo $image[0] ?>" width="<?php echo $image[1] ?>" height="<?php echo $image[2] ?>" data-fullsrc="<?php echo $full_image ?>" alt=""/>
							<?php 
						}
					?>				
				</div>
			</div>
			<?php
		} else {
			get_template_part( 'entry', 'content' );
		}
		?>

		<?php endwhile;?>

		<?php get_template_part( 'nav', 'below-single' ); ?>
		<?php if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) { comments_template( '', true ); } ?>

	</section>

<?php get_footer(); ?>