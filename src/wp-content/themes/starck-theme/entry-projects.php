	<?php
	global $projects;

	$defaults = array(
		'post_type' => $projects['post_type'],
		//'posts_per_page' => 2,
		'order' => 'ASC',
		'orderby' => 'name',
		'paged' => ($paged) ? $paged : 1,
	);

	//if (!$args['paged']) $defaults = wp_parse_args( $defaults, ['paged' => 1]);

	if ( $term_id || get_query_var('term') )
		$args = array(
			'tax_query' => array(
				array(
					'taxonomy' => $projects['taxonomy'],
					'field' => 'id',
					'terms' => ($term_id) ? $term_id : get_queried_object()->term_id,
				)
			)
		);

	$args = wp_parse_args( $defaults, $args );

	$loop =new WP_Query( $args );
	$max_pages = $loop->max_num_pages; // узнаем общее количество страниц постов

		while ( $loop->have_posts() ) : $loop->the_post();
		/* Query the post */
			$hide_title = get_post_meta( $post->ID, 'hide-title', true ) ? ' hidden' : '';
			$title = get_the_title();
			$description = wp_strip_all_tags( ( has_excerpt() ) ? get_the_excerpt() : get_the_content(), true ); //delete all html tags and add space instead of caret brake

			if ( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio') )
				$image_ratio = 'style="padding-top: ' . ($image[2]/$image[1]*100) . '%"';
			echo '<div class="portfolio row slide lazyload" data-expand="-50">';
				echo '<a class="portfolio-image col-md-5 col-lg-6" href="' . get_permalink($post->ID) . '">';
					echo '<div class="img-container" ' . $image_ratio . '>';
						echo '<img class="lazyload" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==" src="' . $image[0] . '" data-srcset="' . wp_get_attachment_image_srcset(get_post_thumbnail_id( $post->ID ), "medium" ). '" data-sizes="auto" alt="' . printf( __('Project %s', 'starck'), $title) . '"/>';
					echo '</div>';
				echo '</a>';

				if ( !empty($title) && empty($hide_title) || !empty($description) ) {
					echo '<div class="portfolio-meta col-md-7 col-lg-6">';
						echo '<input type="checkbox" checked>';
						echo '<header class="portfolio-meta-header' . $hide_title .'"><h2>' . $title . '</h2>';
							if ( !empty($description) ) echo '<i class="close-icon"></i>';
						echo '</header>';
						if ( !empty($description) ) echo '<div class="portfolio-meta-description"><p>' . $description . '</p></div>';
					echo '</div>';
				}
			echo '</div>';
		endwhile;
		if ($args['paged'] < $max_pages)  { // если текущая страница меньше общего числа страниц, то выводим кнопку для подгрузки
			$next_page = $args['paged'] + 1; // в дата атрибуты кнопки передаем номер следующей страницы и id текущих терминов
			echo '<div id="projects-load-more" class="button" href="#" data-id="' . $args['tax_query'][0]['terms'] . '" data-page="' . $next_page . '">' . __('Show more', 'starck') . '</div>';
		}

	wp_reset_postdata();
