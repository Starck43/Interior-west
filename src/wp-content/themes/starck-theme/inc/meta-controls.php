<?php
/*
Plugin Name: Page Layout Controls
Description: Allows to hide the title on single pages and posts via edit mode 
			 and build Gallery for posts and pages.
Version: 1.0.1
Author: S.Shabalin
*/

if ( !class_exists( 'starck_meta_controls' ) ) {

    class starck_meta_controls {

    	private $title_slug = 'hide-title';
    	private $gallery_slug = 'gallery-image';
    	private $gallery_scroll = 'gallery-autoscroll';
    	private $gallery_pagination = 'gallery-pagination';
    	private $screen = array( 'post', 'page' );

        /**
        * PHP 5 Constructor
        */
        function __construct(){

	        add_action( 'add_meta_boxes', array( $this, 'add_section' ) );
			add_action( 'save_post', array( $this, 'save_meta' ) );
			add_action( 'delete_post', array( $this, 'delete_meta' ) );

        } // __construct()



 		function add_section(){

			add_meta_box( $this->title_slug, 'Title', array( $this, 'title_metabox_callback' ), $screen, 'side', 'default' );

			add_meta_box( $this->gallery_slug, 'Gallery', array( $this, 'gallery_metabox_callback' ), $screen, 'side', 'default' );

		}


		function title_metabox_callback( $post ){

			$value = get_post_meta( $post->ID, $this->title_slug, true );

			$checked = '';

			if ( (bool)$value ) { $checked = ' checked="checked"'; }

			wp_nonce_field( $this->title_slug . '_dononce', $this->title_slug . '_noncename' );

			?>
			<label><input type="checkbox" name="<?php echo $this->title_slug; ?>" <?php echo $checked; ?> />Скрыть заголовок</label>
			<?php

		}

		function gallery_metabox_callback( $post ){

			wp_nonce_field( $this->gallery_slug . '_dononce', 		$this->gallery_slug . '_noncename' );
			wp_nonce_field( $this->gallery_scroll . '_dononce', 	$this->gallery_scroll . '_noncename' );
			wp_nonce_field( $this->gallery_pagination . '_dononce', $this->gallery_pagination . '_noncename' );

			$gallery 			= get_post_meta( $post->ID, $this->gallery_slug );
			$gallery_scroll 	= get_post_meta( $post->ID, $this->gallery_scroll, true );
			$gallery_pagination = get_post_meta( $post->ID, $this->gallery_pagination, true );

			if ( (bool)$gallery_scroll ) 	{ $scroll_checked = 'checked="checked"'; }
			if ( (bool)$gallery_pagination ){ $pagination_checked = 'checked="checked"'; }

			echo '<div class="gallery-block" style="cursor:pointer;">';
			if ($gallery) {

				foreach ($gallery as $value) {
					$url = wp_get_attachment_image_url(absint($value) );
					echo '<div class="gallery-image"><img src="' . $url . '" />';
					echo '<a class="gallery-del-image" href="#">удалить</a>';
					echo '<input type="hidden" name="gallery-image[]" value="' . $value . '">';
					echo '</div>';
				}
			}
			echo '</div>';
			echo '<div><input type="button" id="upload-button" class="button" value="Добавить фото" /></div>';
			echo sprintf('<label class="gallery-scroll" style="display: %1$s;"><input type="checkbox" name="%2$s" %3$s/>Режим слайдшоу</label>',
							(($gallery) ? 'block' : 'none'),
							$this->gallery_scroll,
							$scroll_checked
						);
			echo sprintf('<label class="gallery-pagination" style="display: %1$s;"><input type="checkbox" name="%2$s" %3$s/>Индикатор слайдов</label>',
							(($gallery) ? 'block' : 'none'),
							$this->gallery_pagination,
							$pagination_checked
						);

		}


		function save_meta( $post_ID ) {

			if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
				||  !(		$_POST[ $this->title_slug . '_noncename' ]
						 && $_POST[ $this->gallery_slug . '_noncename' ]
						 && $_POST[ $this->gallery_scroll . '_noncename' ]
						 && $_POST[ $this->gallery_pagination . '_noncename' ]
					) 
				|| 	!(		wp_verify_nonce( $_POST[ $this->title_slug . '_noncename' ], 		$this->title_slug . '_dononce' )
						 && wp_verify_nonce( $_POST[ $this->gallery_slug . '_noncename' ], 		$this->gallery_slug . '_dononce' )
						 && wp_verify_nonce( $_POST[ $this->gallery_scroll . '_noncename' ], 	$this->gallery_scroll . '_dononce' )
						 && wp_verify_nonce( $_POST[ $this->gallery_pagination . '_noncename' ],$this->gallery_pagination . '_dononce' )
					) 
				) { return $post_ID; }

			//Update Title meta
			$old = get_post_meta( $post_ID, $this->title_slug, true );
			$new = $_POST[ $this->title_slug ];
			if ( $old != $new ) {
				if ( $new ) { 
					add_post_meta( $post_ID, $this->title_slug, $new, true ); 
				} else {
					delete_post_meta( $post_ID, $this->title_slug );
				}
			}

			//Update Gallery meta
			(array)$old = [];
			(array)$new = [];
			$old = get_post_meta( $post_ID, $this->gallery_slug );
			$new = $_POST[ $this->gallery_slug ];

			if ( $old != $new ) {
				if ( $old ) { 
					delete_post_meta( $post_ID, $this->gallery_slug ); 
					//update_option( 'content_header_gallery', 'disabled', true );
				}
				if ( $new ) {
					for ( $i = 0; $i < count($new); $i++) {
						add_post_meta( $post_ID, $this->gallery_slug, $new[$i] ); 
					}
				}
			}

			//Update Gallery autoscroll meta
			(string)$old = '';
			(string)$new = '';
			$old = get_post_meta( $post_ID, $this->gallery_scroll, true );
			$new = $_POST[ $this->gallery_scroll ];

			if ( $old != $new ) {
				if ( $new ) { 
					add_post_meta( $post_ID, $this->gallery_scroll, $new, true ); 
				} else {
					delete_post_meta( $post_ID, $this->gallery_scroll );
				}
			}

			//Update Gallery pagination meta
			(string)$old = '';
			(string)$new = '';
			$old = get_post_meta( $post_ID, $this->gallery_pagination, true );
			$new = $_POST[ $this->gallery_pagination ];

			if ( $old != $new ) {
				if ( $new ) { 
					add_post_meta( $post_ID, $this->gallery_pagination, $new, true ); 
				} else {
					delete_post_meta( $post_ID, $this->gallery_pagination );
				}
			}

			return $post_ID;

		} // save_meta


		function delete_meta( $post_ID ){

			delete_post_meta( $post_ID, $this->title_slug );
			delete_post_meta( $post_ID, $this->gallery_slug );
			delete_post_meta( $post_ID, $this->gallery_scroll );
			delete_post_meta( $post_ID, $this->gallery_pagination );
			
			return $post_ID;

		} // delete_meta


    } // starck_meta_controls

    $starck_meta_controls = new starck_meta_controls;

}