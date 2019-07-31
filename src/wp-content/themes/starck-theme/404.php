<?php get_header(); ?>

<main id="main">

<div id="content" role="main">

<article id="post-0" class="post not-found">

<header class="post-header">
<h1 class="entry-title"><?php esc_html_e( 'Not Found', 'starck' ); ?></h1>
</header>

<div class="entry-content">
<p><?php esc_html_e( 'Nothing found for the requested page. Try a search instead?', 'starck' ); ?></p>
<?php get_search_form(); ?>
</div>

</article>

<div class="goto-back">
<a href = "#" <?php echo 'onclick="javascript:history.back(); return false;"'?>><span class="fa fa-angle-left"></span><?php esc_html_e( 'Go back', 'starck' ); ?></a>
</div>

</div>

<?php get_sidebar(); ?>

</main>

<?php get_footer(); ?>