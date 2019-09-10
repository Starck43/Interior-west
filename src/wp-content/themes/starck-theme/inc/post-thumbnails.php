<?php

add_filter('manage_posts_columns','posts_columns',5);
add_filter('manage_posts_custom_column','posts_custom_columns',5,2);

function posts_columns($columns) {
	$columns = array (
		'cb' => $columns['cb'],
		'post_thumb' => __('Миниатюра'),
		'title' => __('Title'),
		'date' => __('Date'),
	);
	return $columns;
}

function posts_custom_columns($column_name, $id) {

	if ($column_name === 'post_thumb') {
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( array(50,50) );
		} else echo 'No Image';
	}
}

add_action('admin_head', 'thumb_styles');
function thumb_styles() {
	echo '<style>
		.column-post_thumb {width: 80px;}
		.postbox-gallery-image {
			position: relative;
			display: inline-block;
			margin: 0.5%;
			max-width: 9%;
		}
		.postbox-gallery-image img {width: 100%; height: auto;}
		.postbox-gallery-image .gallery-del-image {
			position: absolute; 
			right: 4px; 
			top: 4px;
			border-radius: 50%;
			background: rgba(255,255,255,.8);
			width: 20px;
			height: 20px;
			text-align: center;
			font-size: 15px;
		}
		#gallery-image .button {margin: 5px 0 10px;}
	</style>';
}