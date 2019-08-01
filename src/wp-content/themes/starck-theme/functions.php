<?php

//echo get_home_url( null, 'wp-admin/', 'https' ); //Example.com: https://example.com/wp-admin/
$home_url = get_stylesheet_directory_uri(); // for theme-child URL //get_home_url();
$main_css_file = '/main.min.css';
if ( !file_exists( $home_url . '/css' . $main_css_file )) $main_css_file = '/main.css';


// STYLES registry
wp_enqueue_style( 'mytheme-styles', $home_url . '/css' . $main_css_file);
wp_enqueue_style( 'vendors-styles', $home_url . '/css/vendors.min.css');
// !!! Check for dublicates of the styles below in css/vendors.css via @import
//wp_enqueue_style( 'magnific-popup', $home_url . '/plugins/magnific-popup/dist/magnific-popup.css');
//wp_enqueue_style( 'font-awesome-styles', $home_url . '/plugins/awesome/css/font-awesome.min.css');

// SCRIPTS registry
add_action( 'mytheme_enqueue_scripts', 'mytheme_scripts_add' );
function mytheme_scripts_add() {
	wp_enqueue_script('my_custom_scripts', $home_url . '/js/custom.min.js');
	wp_enqueue_script('vendors_scripts', $home_url . '/js/vendors.min.js');
}

// END ENQUEUE PARENT ACTION

//добавление опции установки логотипа через настройки темы
add_theme_support( 'custom-logo', array(
	'height'      => 100,
	'width'       => 400,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
) );

add_action( 'after_setup_theme', 'starck_setup' );
function starck_setup() {
load_theme_textdomain( 'starck', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'search-form' ) );
global $content_width;
if ( ! isset( $content_width ) ) { $content_width = 1920; }
register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'starck' ) ) );
}

add_action( 'wp_footer', 'starck_footer_scripts' );
function starck_footer_scripts() {
?>
<script>
jQuery(document).ready(function ($) {
var deviceAgent = navigator.userAgent.toLowerCase();
if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
$("html").addClass("ios");
$("html").addClass("mobile");
}
if (navigator.userAgent.search("MSIE") >= 0) {
$("html").addClass("ie");
}
else if (navigator.userAgent.search("Chrome") >= 0) {
$("html").addClass("chrome");
}
else if (navigator.userAgent.search("Firefox") >= 0) {
$("html").addClass("firefox");
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
$("html").addClass("safari");
}
else if (navigator.userAgent.search("Opera") >= 0) {
$("html").addClass("opera");
}
});
</script>
<?php
}
add_filter( 'document_title_separator', 'starck_document_title_separator' );
function starck_document_title_separator( $sep ) {
$sep = '|';
return $sep;
}
add_filter( 'the_title', 'starck_title' );
function starck_title( $title ) {
if ( $title == '' ) {
return '...';
} else {
return $title;
}
}
add_filter( 'the_content_more_link', 'starck_read_more_link' );
function starck_read_more_link() {
if ( ! is_admin() ) {
return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">...</a>';
}
}
add_filter( 'excerpt_more', 'starck_excerpt_read_more_link' );
function starck_excerpt_read_more_link( $more ) {
if ( ! is_admin() ) {
global $post;
return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">...</a>';
}
}
add_filter( 'intermediate_image_sizes_advanced', 'starck_image_insert_override' );
function starck_image_insert_override( $sizes ) {
unset( $sizes['medium_large'] );
return $sizes;
}
add_action( 'widgets_init', 'starck_widgets_init' );
function starck_widgets_init() {
register_sidebar( array(
'name' => esc_html__( 'Sidebar Widget Area', 'starck' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
//add_action( 'wp_head', 'starck_pingback_header' );
function starck_pingback_header() {
if ( is_singular() && pings_open() ) {
printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
}
}
add_action( 'comment_form_before', 'starck_enqueue_comment_reply_script' );
function starck_enqueue_comment_reply_script() {
if ( get_option( 'thread_comments' ) ) {
wp_enqueue_script( 'comment-reply' );
}
}
function starck_custom_pings( $comment ) {
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php
}
add_filter( 'get_comments_number', 'starck_comment_count', 0 );
function starck_comment_count( $count ) {
if ( ! is_admin() ) {
global $id;
$get_comments = get_comments( 'status=approve&post_id=' . $id );
$comments_by_type = separate_comments( $get_comments );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}