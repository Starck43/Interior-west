	<?php
	global $wp_query;

	$loop = ( $args ) ? new WP_Query( $args ) : $wp_query;
	$max_pages = $loop->max_num_pages; // узнаем общее количество страниц постов
	if ( $projects['show_title'] ) {
		if ($args['tax_query']) { //если есть запрос по таксономии, то выведем название категории из полученного запроса
			$term = get_the_terms($loop->posts[0]->ID, $projects['taxonomy'])[0];
			$cat_name = $term->name;
		} else $cat_name = $projects['all_posts_title'];
		echo '<header id="category-header"><h2 class="subtitle">' . $cat_name .'</h2></header>';
	}

	while ( $loop->have_posts() ) : $loop->the_post(); 
	/* Query the post */
		$hide_title = get_post_meta( $loop->post->post_id, 'hide-title', true ) ? ' hidden' : '';
		$project_excerpt = get_the_excerpt();
		if ( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio') )
			$image_ratio = 'style="padding-top: ' . ($image[2]/$image[1]*100) . '%"';

			echo '<a class="portfolio col-6" href="' . get_permalink($post->ID) . '">';
			echo '<div class="portfolio-container" ' . $image_ratio . '>';
				echo '<img class="portfolio-image lazyload" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==" src="' . $image[0] . '" data-srcset="' . wp_get_attachment_image_srcset(get_post_thumbnail_id( $post->ID ), "medium" ). '" data-sizes="auto" data-expand="-50" alt="Проект"/>';
				if ( !empty($hide_title) || !empty($project_excerpt) ) {
					echo '<div class="portfolio-image-meta">';
						echo '<h2 class="meta-title' . $hide_title .'">';
							the_title();
						echo '</h2>';
						echo '<div class="meta-description">' . $project_excerpt .'</div>';
					echo '</div>';
				}
			echo '</div>';
		echo '</a>';
	endwhile;
	wp_reset_postdata();
