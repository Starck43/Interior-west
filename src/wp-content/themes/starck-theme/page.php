<?php
/*
 * The template for displaying all single posts
 *
 * @package Starck-theme
 */
get_header(); ?>

	<section id="content" <?php starck_content_class('page'); ?>>

		<?php starck_breadcrumbs(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<article class="entry post-<?php the_ID(); ?> row" <?php post_class(); ?>>

				<header class="entry-header">
					<?php if (get_post_meta( $post->ID, 'hide-title', true )) $hidden_class = ' hidden'; ?>
					<h1 class="entry-title <?php echo $hidden_class ?>"><?php the_title(); ?></h1>
					<?php edit_post_link(); ?>
				</header>

				<?php
				if ( has_post_thumbnail() ) { ?>
					<div class="entry-thumbnail cell col-md-5">
						<?php the_post_thumbnail('portfolio','class=lazyload'); ?>
					</div>
				<?php
					$cell = ' cell col-md-7';
				} else $cell = '';
				?>

				<div class="entry-content<?php echo $cell; ?>">
					<?php the_content(); ?>
					<div class="entry-links"><?php wp_link_pages(); ?></div>
				</div>

			</article>

		<?php endwhile;?>

	</section>

	<?php starck_get_sidebar();

get_footer();

?>