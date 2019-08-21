<?php get_header(); ?>

	<section id="content" <?php starck_content_class(); ?>>
	
		<?php starck_breadcrumbs(); ?>
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<?php if (get_post_meta( $post->ID, 'hide-title', true )) $hidden_class = ' hidden'; ?>
					<h1 class="entry-title <?php echo $hidden_class ?>"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
				</header>

				<div class="entry-content">
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
					<?php the_content(); ?>
					<div class="entry-links"><?php wp_link_pages(); ?></div>
				</div>

			</article>

			<?php if ( comments_open() && ! post_password_required() ) { comments_template( '', true ); } ?>

		<?php endwhile; endif; ?>

	</section>

	<?php starck_get_sidebar(); ?>

<?php get_footer(); ?>