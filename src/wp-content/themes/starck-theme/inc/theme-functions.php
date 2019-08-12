<?php
define( 'STARCK_VERSION', '1.0.4' );

add_action( 'after_setup_theme', 'starck_setup' );
function starck_setup() {
	load_theme_textdomain( 'starck', get_template_directory() . '/languages' );

	//добавление фонового изображения через настройки темы
	add_theme_support( 'custom-background', array(
		'default-color'          => '',
		//'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	) );

	add_theme_support( 'custom-header', array(
		'width'					=> 1920,
		'height'				=> 1080,
		'flex-height'			=> true,
		'flex-width'			=> true,
		'default-text-color'	=> 'white',
		'header-text'			=> true,
		'uploads'				=> true,
		'default-image'			=> get_template_directory() . '/img/header.jpg',
	) );

	//добавление опции установки логотипа через настройки темы
	add_theme_support( 'custom-logo', array(
		'width'       => 400,
		'height'      => 120,
		'flex-width'  => true,
		'flex-height' => true,
		'uploads' 	  => true,
		'default-image' => get_template_directory() . '/img/logo.png',
		'header-text' => array( 'site-title', 'site-description' )
	) );

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status' ) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-color-palette', array() );
	//add_theme_support( 'woocommerce' );
	

	global $content_width;
	if ( ! isset( $content_width ) ) { $content_width = 1920; }

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'starck' ),
	) );
	register_nav_menus( array(
		'secondary' => __( 'Secondary Menu', 'starck' ),
	) );

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

add_action( 'wp_head', 'starck_pingback_header' );
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

if ( ! function_exists( 'starck_get_link_url' ) ) {
	/**
	 * Return the post URL.
	 *
	 * @return string The Link format URL.
	 */
	function starck_get_link_url() {
		$has_url = get_url_in_content( get_the_content() );

		return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}

/**
 * Check if the logo and site branding are active.
 *
 */
function starck_has_logo_site_branding() {
	if ( get_theme_mod( 'custom_logo' ) && !starck_get_option( 'hide_title' ) ) {
		return true;
	} else {
		return false;
	}
}

if ( ! function_exists( 'starck_widgets_init' ) ) {
	add_action( 'widgets_init', 'starck_widgets_init' );
	/**
	 * Register widgets area
	 */
	function starck_widgets_init() {
		$widgets = array(
			'sidebar' => __( 'Sidebar', 'starck' ),
			'header' => __( 'Header', 'starck' ),
			'top-bar' => __( 'Top Bar','starck' ),
			'footer-1' => __( 'Footer 1', 'starck' ),
			'footer-2' => __( 'Footer 2', 'starck' ),
			'footer-3' => __( 'Footer 3', 'starck' ),
		);

		foreach ( $widgets as $id => $name ) {
			register_sidebar( array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<section id="%1$s" class="widget">',
				'after_widget'  => '</section>',
				'before_title'  => apply_filters( 'starck_start_widget_title', '<h2 class="widget-title">' ),
				'after_title'   => apply_filters( 'starck_end_widget_title', '</h2>' ),
			) );
		}
	}
}


require_once trailingslashit( dirname( __FILE__ ) ) . 'customizer.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'defaults.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'markup.php';


//Theme functions define


/**
 * Add custom header classes to <header> element.
 * @param string|array $merged_class. Classes to add to the class list.
 */
function starck_header_class( $merged_class = '' ) {
	return apply_filters( "starck_add_header_class", $merged_class );
}

/**
 * Add custom branding classes to <id="branding"> element.
 * @param string|array $merged_class. Classes to add to the class list.
 */
function starck_branding_class( $merged_class = '' ) {
	return apply_filters( "starck_add_branding_class", $merged_class );
}

/**
 * Add custom search classes to <id="search"> element.
 * @param string|array $merged_class. Classes to add to the class list.
 */
function starck_search_class( $merged_class = '' ) {
	return apply_filters( "starck_add_search_class", $merged_class );
}

/**
 * Add custom menu classes to <nav> element.
 * @param string|array $merged_class. Classes to add to the class list.
 */
function starck_navigation_class( $merged_class = '' ) {
	return apply_filters( "starck_add_navigation_class", $merged_class );
}

/**
 * Add custom main classes to <main> element.
 * @param string|array $merged_class. Classes to add to the class list.
 */
function starck_main_class( $merged_class = '' ) {
	return apply_filters( "starck_add_main_class", $merged_class );
}

/**
 * Add custom content classes to <section id='content'> element.
 * @param string|array $merged_class. Classes to add to the class list.
 */
function starck_content_class( $merged_class = '' ) {
	return apply_filters( "starck_add_content_class", $merged_class );
}

/**
 * Add custom sidebar classes to <aside id='main-sidebar'> element.
 * @param string|array $merged_class. Classes to add to the class list.
 */
function starck_sidebar_class( $merged_class = '' ) {
	return apply_filters( "starck_add_sidebar_class", $merged_class );
}

/**
 * Add custom footer classes to <footer> element.
 * @param string|array $merged_class. Classes to add to the class list.
 */
function starck_footer_class( $merged_class = '' ) {
	return apply_filters( "starck_add_footer_class", $merged_class );
}


function starck_get_option( $option ) {
	$defaults = starck_get_defaults();

	if ( ! isset( $defaults[ $option ] ) ) {
		return;
	}

	$options = wp_parse_args(
		get_option( 'starck_settings', array() ), $defaults
	);

	return $options[ $option ];
}

if ( ! function_exists( 'starck_get_layout' ) ) {
	/**
	 * Get the sidebar layout for the current page.
	 *
	 * @return string
	 */
	function starck_get_layout() {

		if ( is_home() || is_archive() || is_search() || is_tax() ) {
			$layout = starck_get_option( 'blog_layout_setting' );
		} else
		if ( is_single() ) {
			$layout = starck_get_option( 'single_layout_setting' );
		} else
			$layout = starck_get_option( 'layout_setting' );

		return apply_filters( 'starck_sidebar_layout', $layout );
	}
}

if ( ! function_exists( 'starck_get_sidebar' ) ) {
	/**
	 * Construct Sidebar
	 */
	function starck_get_sidebar() {
		$layout = starck_get_layout();

		// If sidebar, show it.
		if ( in_array( $layout, ['left-sidebar','right-sidebar'] ) ) {
			get_sidebar();
		}
	}
}

if ( ! function_exists( 'starck_get_top_bar' ) ) {
	/**
	 * Construct Top Bar
	 */
	function starck_get_top_bar() {	
		if ( ! is_active_sidebar( 'top-bar' ) ) { return; }
		?>
		<div id="top-bar" class="container">
			<?php dynamic_sidebar( 'top-bar' ); ?>
		</div>
		<?php 
	}
}

if ( ! function_exists( 'starck_get_header_widget' ) ) {
	/**
	 * Build our header widget.
	 */
	function starck_get_header_widget() {	
		if ( ! is_active_sidebar( 'header' ) ) { return; }
		dynamic_sidebar( 'header' );
	}
}

if ( ! function_exists( 'starck_get_footer_widgets' ) ) {
	/**
	 * Build our footer widgets.
	 */
	function starck_get_footer_widgets( $widgets ) {

		if (
			! is_active_sidebar( 'footer-1' ) &&
			! is_active_sidebar( 'footer-2' ) &&
			! is_active_sidebar( 'footer-3' ) )
		{
			return;
		}
		?>

		<div id="footer-widgets" class="site footer-widgets">
			<?php
			if ( $widgets >= 1 ) { starck_add_footer_widget( 1 ); }
			if ( $widgets >= 2 ) { starck_add_footer_widget( 2 ); }
			if ( $widgets >= 3 ) { starck_add_footer_widget( 3 ); }
			?>
		</div>
		<?php
	}
}


/**
 * Build every preset footer widget
 */
function starck_add_footer_widget( $widget ) {
	?>
	<div class="footer-widget footer-widget-<?php echo absint( $widget ); ?>">
		<?php dynamic_sidebar( 'footer-' . absint( $widget ) ); ?>
	</div>
	<?php
}