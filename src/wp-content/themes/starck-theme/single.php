<?php get_header(); ?>

<main id="main">

<div id="content" role="main">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php if ( comments_open() && ! post_password_required() ) { comments_template( '', true ); } ?>
<?php endwhile; endif; ?>

<?php get_template_part( 'nav', 'below-single' ); ?>

</div>

<?php get_sidebar(); ?>

</main>

<?php get_footer(); ?>