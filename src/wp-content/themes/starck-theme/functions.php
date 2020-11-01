<?php
define( 'STARCK_VERSION', '1.8.9' );

//!-- START ENQUEUE PARENT ACTION

//$home_url = get_home_url( null, 'wp-admin/', 'https' ); //Example.com: https://example.com/wp-admin/
$home_url = get_stylesheet_directory_uri(); // for theme-child URL //get_home_url();
$main_css_file = 'main.min.css';
if ( !file_exists( dirname( __FILE__ ) . '/css/' . $main_css_file )) $main_css_file = 'main.css';


// STYLES registry
if( !is_admin() ) {
	wp_enqueue_style( 'starck-theme', $home_url . '/css/' . $main_css_file, array(), STARCK_VERSION);
	wp_enqueue_style( 'vendors', $home_url . '/css/vendors.min.css', array(), STARCK_VERSION);
}

// !!! Check for dublicates of the styles below in /css/vendors.css via @import
//wp_enqueue_style( 'magnific-popup', $home_url . '/plugins/magnific-popup/dist/magnific-popup.css');
//wp_enqueue_style( 'font-awesome-styles', $home_url . '/plugins/awesome/css/font-awesome.min.css');

// SCRIPTS registry
add_action( 'wp_enqueue_scripts', 'starck_scripts_add',11 );
function starck_scripts_add() {

	$home_url = get_template_directory_uri();

	if ( file_exists( dirname( __FILE__ ) . '/js/jquery.min.js' )) {
		wp_deregister_script( 'jquery' );
		wp_enqueue_script('jquery', $home_url . '/js/jquery.min.js');
	}
	wp_register_script('vendors', $home_url . '/js/vendors.min.js', array('jquery'), STARCK_VERSION, true);
	wp_enqueue_script('vendors');

	wp_register_script('starck-theme', $home_url . '/js/custom.min.js', array('jquery'), STARCK_VERSION, true);
	wp_enqueue_script('starck-theme');
}
//!-- END ENQUEUE PARENT ACTION

require_once get_template_directory() . '/inc/theme-functions.php'; // Include main theme functions
if ( is_admin() )
	require_once get_template_directory() . '/inc/meta-controls.php'; // Include custom meta in pages (i.e. header gallery or hide title)
//require_once get_template_directory() . '/inc/projects_layout.php'; // Include Projects Post Layout
?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(51322627, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/51322627" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
