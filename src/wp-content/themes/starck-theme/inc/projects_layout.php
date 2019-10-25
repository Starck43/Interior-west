<?php 
// Объявим глобальный массив
$projects = array (
	'taxonomy'			=> 'project_cat',
	'post_type'			=> 'projects',
	'all_posts_title'	=> 'Все проекты',
	'show_title'		=> 1 // 1 - Отображать заголовок текущей категории проектов 
);

add_action('init', 'register_projects_post_type_and_taxonomy');

//Creating Custom Post types for Projects
function register_projects_post_type_and_taxonomy() {
	global $projects;

	$labels = array(
		'name' => _x('Категории проектов', 'taxonomy general name'),
		'singular_name' => _x('Категория проектов', 'taxonomy singular name'),
		'add_new_item' => __('Добавить категорию'),
		'edit_item' => __('Изменить категорию'),
		'new_item' => __('Новая категория'),
		'view_item' => __('Посмотреть категорию'),
		'parent_item' => null,
		'parent_item_colon' => null,
		'all_items' => __('Все категории'),
		'update_item' => __('Обновить'),
		'search_items' => __('Поиск категории'),
		'not_found' => __('Категории не найдены'),
		'not_found_in_trash' => __('Не найдено в корзине')
		);
	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'label' => 'Категории проектов',  //Label Displayed in the Admin when creating a new project
		'public' => true,
		//'query_var' => false,
		'rewrite' => array(
			'hierarchical' => true,
			'slug' => $projects['post_type'], // This controls the base slug that will display before each term
			'with_front' => true // Display the category prefix before 
		),
		'show_admin_column' => true
	);
	//projects_cat - the name of the taxonomy. Name should be in slug form (no spaces and all lowercase)
	//projects - post type name
	register_taxonomy( $projects['taxonomy'], $projects['post_type'], $args );


	$labels = array(
		'name' => _x('Проекты', 'post type general name'),
		'singular_name' => _x('Проект', 'post type singular name'),
		'add_new' => _x('Добавить проект', 'Project'),
		'add_new_item' => __('Добавить проект'),
		'edit_item' => __('Изменить проект'),
		'new_item' => __('Новый проект'),
		'all_items' => __('Все проекты'),
		'view_item' => __('Посмотреть проект'),
		'update_item' => __('Посмотреть проект'),
		'search_items' => __('Поиск проектов'),
		'not_found' => __('Проекты не найдены'),
		'not_found_in_trash' => __('Не найдено в корзине'),
		'parent_item_colon' => '',
		'menu_name' => 'Проекты'
		);
	$args = array(
		'labels' => $labels,
		'description' => 'Проекты',
		'show_ui' => true,
		'public' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor', 'page-attributes', 'thumbnail', 'custom-fields'),
		'rewrite' => array(
			'slug' => $projects['post_type'] . '/%' . $projects['taxonomy'] . '%',
			'with_front' => false
		),
		'query_var' => true,
		'has_archive' => true,
		'taxonomies' => array( $projects['taxonomy']),
		'menu_icon' => 'dashicons-admin-multisite', //Find the appropriate dashicon here: https://developer.wordpress.org/resource/dashicons/
		);
	register_post_type($projects['post_type'], $args);
}

add_filter('post_type_archive_link', 'projects_permalink', 10, 2);
add_filter('post_type_link', 'projects_hierarchical_permalink', 1, 2);

function projects_permalink( $permalink, $post_type ){
	global $projects;

	// выходим если это не наш тип записи: без холдера %%
	if( strpos($permalink, '%' . $projects['taxonomy'] . '%') === FALSE )
		return $permalink;

	// Получаем элементы таксы
	$terms = get_the_terms(get_post(), $projects['taxonomy']);
	// если есть элемент заменим холдер
	if( ! is_wp_error($terms) && !empty($terms) && is_object($terms[0]) ) {
		$term_slug = array_pop($terms)->slug;
	}
	else
		$term_slug = '';

	return preg_replace( '#/$#', '', str_replace('%' . $projects['taxonomy'] . '%', $term_slug, $permalink ) );
}


function projects_hierarchical_permalink( $permalink, $post ){
	global $projects;

	if( strpos($permalink, '%' . $projects['taxonomy'] . '%') === FALSE )
		return $permalink;

	// Получаем элементы таксы
	$terms = get_the_terms($post,  $projects['taxonomy']);
	$parent = $terms[0]->parent;
 
	// если есть элемент заменим холдер
	if( ! is_wp_error($terms) && !empty($terms) && is_object($terms[0]) ) {
		$term_slug = array_pop($terms)->slug;
		while( $parent ) {
			$parent_term = get_term($parent, $projects['taxonomy']);
			$term_slug = $parent_term->slug . '/' . $term_slug;
			$parent = $parent_term->parent;
		}
	}	
	else 
		$term_slug = '';
		// В $permalink находим %project_cat% и заменяем на $term_slug
	// убираем лишний слэш, если $term_slug будет пустой
	return preg_replace( '#/$#', '', str_replace('%' . $projects['taxonomy'] . '%', $term_slug, $permalink ) );
}


// смена запроса
add_filter('request', 'action_function_name',1,1 );
function action_function_name( $query ) {
	global $projects;
	$cat = $projects['taxonomy'];
	if( isset($query[$cat]) ) { //здесь и далее название таксономии
		$str = strrchr($query[$cat],'/');
		$name = str_replace('/','',$str); //удалим слэшы
		$term = get_term_by( 'slug', $name , $cat);
		if( !$term && $name ) {
			$query[$cat] = str_replace($str,'',$query[$cat]);
			$query['post_type'] = $projects['post_type']; //название пользовательского типа записей
			//$query[$projects['post_type']] = $name; //$query['название пользовательского типа записей']
			$query['name'] = $name;
		}
    }
	//var_dump($query);

    return $query;
}


// Delete a sidebar in custom projects posts
add_filter( 'starck_sidebar_layout', 'remove_projects_sidebar' );
function remove_projects_sidebar($layout) {
	$layout = 'no-sidebar';
	return $layout;
}

// Отдаем приоритет странице, если ее адрес совпадает с категорией поста
/*add_filter('page_rewrite_rules', 'wpse16902_collect_page_rewrite_rules');
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
*/

add_action('wp_ajax_projects_filter', 'projects_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_projects_filter', 'projects_filter_function');
 
function projects_filter_function() {
	global $projects;

	//var_dump($_POST['term']);
	$paged = $_POST['paged'] ? $_POST['paged'] : 1; // Если в paged пусто, то будем считать, что нужна первая страница
	// for taxonomies / categories
	$args = array( // составляем запрос
		'post_type' => $projects['post_type'],
		'posts_per_page' => 10,
		'order' => 'ASC',
		'orderby' => 'name',
		'paged' => $paged,
	);

	if( isset( $_POST['term'] ) ) { //если передан запрос методом POST
		$args['tax_query'][] = array(
			'taxonomy' => $projects['taxonomy'],
			'field' => 'slug',
			'terms' => $_POST['term'],
		);
	}

	render_partial('entry-projects.php', ['args' => $args, 'projects' => $projects]);
	//get_template_part( 'entry','projects' );
	die();
}

function get_taxonomy_list_categories($projects) {

	$current_term = is_tax() ? get_queried_object() : null;
	// Выводим все термы для таксономии project_cat
	$terms = get_terms( [
		'taxonomy'		=> $projects['taxonomy'],
		'parent'		=> ($current_term ? $current_term->term_id : 0),
		'hide_empty' 	=> 1,
		'hierarchical'	=> 0,
	] );

	var_dump(get_query_var('taxonomy'));
	if ( $terms ) {
		?>
		<ul id="projects-categories" class="projects-categories">
			<?php
			echo '<li class="cat-item-all current-cat"><a href="' . ($current_term ? get_term_link($current_term) : '/' . $projects['post_type']) . '">' . $projects['all_posts_title'] . '</a></li>';

			foreach ($terms as $term) {
				echo '<li class="cat-item cat-item-' . $term->term_id . '">';
					echo '<a href="/' . $projects['post_type'] . '/' . $term->slug . '" data-name="' . $term->slug . '">' . $term->name . '</a>';
				echo '</li>';
			}
			?>
		</ul>
		<?php
	}
}

add_action('wp_head','js_variables');
function js_variables(){
    $variables = array (
        'ajax_url' => admin_url('admin-ajax.php'),
    );
    echo '<script type="text/javascript">window.wp_data = ' . json_encode($variables) . ';</script>';
}

if (!function_exists('render_partial')) {
    function render_partial($template, $render_data)
    {
        extract($render_data);
        require locate_template($template);
    }
}