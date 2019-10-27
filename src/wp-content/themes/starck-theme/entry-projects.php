	<?php
	global $wp_query;

	$loop = ( $args ) ? new WP_Query( $args ) : $wp_query;
	$max_pages = $loop->max_num_pages; // узнаем общее количество страниц постов

		while ( $loop->have_posts() ) : $loop->the_post(); 
		/* Query the post */
			$hide_title = get_post_meta( $post->ID, 'hide-title', true ) ? ' hidden' : '';
			$title = get_the_title();
			$description = get_the_excerpt();
			if ( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio') )
				$image_ratio = 'style="padding-top: ' . ($image[2]/$image[1]*100) . '%"';
				echo '<a class="portfolio col-6" href="' . get_permalink($post->ID) . '">';
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

	wp_reset_postdata();

