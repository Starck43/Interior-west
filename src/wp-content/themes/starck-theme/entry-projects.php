	<?php
	global $projects;

	$defaults = array( 
		'post_type' => $projects['post_type'],
		'posts_per_page' => 2,
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
			$description = get_the_excerpt();
			if ( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio') )
				$image_ratio = 'style="padding-top: ' . ($image[2]/$image[1]*100) . '%"';
				echo '<a class="portfolio col-sm-6" href="' . get_permalink($post->ID) . '">';
				echo '<div class="img-container" ' . $image_ratio . '>';
					echo '<img class="portfolio-image lazyload" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==" src="' . $image[0] . '" data-srcset="' . wp_get_attachment_image_srcset(get_post_thumbnail_id( $post->ID ), "medium" ). '" data-sizes="auto" data-expand="-50" alt="Проект"/>';
					if ( !empty($title) && empty($hide_title) || !empty($description) ) {
						echo '<div class="portfolio-image-meta">';
							echo '<h3 class="meta-title' . $hide_title .'">' . $title . '</h3>';
							echo '<div class="meta-description">' . $description . '</div>';
						echo '</div>';
					}
				echo '</div>';
			echo '</a>';
		endwhile;
		if ($args['paged'] < $max_pages)  { // если текущая страница меньше общего числа страниц, то выводим кнопку для подгрузки
			$next_page = $args['paged'] + 1; // в дата атрибуты кнопки передаем номер следующей страницы и id текущих терминов
			echo '<a id="projects-load-more" class="button" href="#" data-id="' . $args['tax_query'][0]['terms'] . '" data-page="' . $next_page . '">Показать еще</a>';
		}
/*
		if( $max_pages > 1 ) { // если страниц больше одной, то выводим кнопку с data-атрибутом следующей страницы
			echo '<a id="projects-load-more" href="#" data-page="2">Показать еще</a>';
		}*/

	wp_reset_postdata();

