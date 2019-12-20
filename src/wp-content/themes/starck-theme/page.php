<?php
/*
 * The template for displaying all single posts
 *
 * @package Starck-theme
 * Version 1.8.7
 */
get_header(); ?>

	<?php $page_width = get_post_meta( $post->ID, 'page-width', true ); ?>
	<section id="content" <?php starck_content_class('page'); ?>>

		<?php starck_breadcrumbs(); ?>

		<?php while ( have_posts() ) : the_post();
			if ( get_the_content() ) {
			?>
				<article class="entry post-<?php the_ID(); ?>" <?php post_class(); echo (bool)$page_width ? ' style="max-width:'.$page_width.'px"' : ''; ?>>

					<header class="entry-header">
						<?php  $hidden_class = (get_post_meta( $post->ID, 'hide-title', true )) ? ' hidden' : ''; ?>
						<h1 class="entry-title<?php echo $hidden_class ?>"><?php the_title(); ?></h1>
					</header>

					<?php
					if ( has_post_thumbnail() ) { ?>
						<div class="entry-thumbnail cell col-md-5">
							<?php the_post_thumbnail('post-thumbnail','class=lazyload'); ?>
						</div>
					<?php
						$cell = ' cell col-md-7';
					} else $cell = '';
					?>
					<div class="entry-content<?php echo $cell; ?>">
						<?php the_content(); ?>
						<?php if ( is_user_admin() ) edit_post_link(); ?>
					</div>
				</article>
			<?php } ?>

		<?php endwhile;?>

	</section>

	<?php starck_get_sidebar();

get_footer();

?>