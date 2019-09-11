<?php 

add_action('init', 'setup_projects_cpt');

//Creating Custom Post types for Projects
function setup_projects_cpt(){
	$labels = array(
		'name' => _x('Проекты', 'post type general name'),
		'singular_name' => _x('Проект', 'post type singular name'),
		'add_new' => _x('Добавить проект', 'Project'),
		'add_new_item' => __('Добавить новый проект'),
		'edit_item' => __('Изменить проект'),
		'new_item' => __('Новый проект'),
		'all_items' => __('Все проекты'),
		'view_item' => __('Посмотреть проект'),
		'search_items' => __('Поиск проектов'),
		'not_found' => __('Проекты не найдены'),
		'not_found_in_trash' => __('Не найдено в корзине'),
		'parent_item_colon' => '',
		'menu_name' => 'Проекты'
		);
	$args = array(
		'labels' => $labels,
		'description' => 'Проекты',
		'public' => true,
		'menu_position' => 5,
		'supports' => array('title', 'thumbnail', 'excerpt', 'custom-fields'),
		'rewrite' => array('slug' => ''),
		'has_archive' => true,
		'taxonomies' => array('project_cat'),
		'menu_icon' => 'dashicons-admin-multisite', //Find the appropriate dashicon here: https://developer.wordpress.org/resource/dashicons/
		);
	register_post_type('projects', $args);
}

add_action( 'init', 'projects_taxonomy'); 
//The following snippet is used to enable categories for the projects CPT. 
function projects_taxonomy() {  
	register_taxonomy(  
		'project_cat',  //The name of the taxonomy. Name should be in slug form (no spaces and all lowercase. no caps). 
		'projects',        //post type name
		array(  
			'hierarchical' => true,
			'label' => 'Категории проектов',  //Label Displayed in the Admin when creating a new project
			'query_var' => true,
			'rewrite' => array(
				'slug' => '', // This controls the base slug that will display before each term
				'with_front' => false // Don't display the category base before 
			)
		)  
	);  
}

add_filter( 'starck_sidebar_layout', 'remove_projects_sidebar' );
function remove_projects_sidebar($layout) {
	$layout = 'no-sidebar';
	return $layout;
}
// Отдаем приоритет старанице, если ее адрес совпадает с категорией поста
add_filter('page_rewrite_rules', 'wpse16902_collect_page_rewrite_rules');
function wpse16902_collect_page_rewrite_rules($page_rewrite_rules)
{
	$GLOBALS['wpse16902_page_rewrite_rules'] = $page_rewrite_rules;
	return array();
}

add_filter('rewrite_rules_array', 'wspe16902_prepend_page_rewrite_rules');
function wspe16902_prepend_page_rewrite_rules($rewrite_rules)
{
	return $GLOBALS['wpse16902_page_rewrite_rules'] + $rewrite_rules;
}
