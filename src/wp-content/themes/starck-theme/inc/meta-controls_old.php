<?php
/*
Plugin Name: Page Layout Controls
Description: Allows to hide the title on single pages and posts via edit mode 
			 and build Gallery for #Main-Header.
Version: 1.0.1
Author: S.Shabalin
*/

if ( !class_exists( 'starck_meta_controls' ) ) {

    class starck_meta_controls {

    	private $title_slug = 'hide-title';
    	private $gallery_slug = 'gallery-images';
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

			wp_nonce_field( $this->gallery_slug . '_dononce', $this->gallery_slug . '_noncename' );
			$images_str = get_post_meta( $post->ID, $this->gallery_slug, true );
			$images_url = explode("|", $images_str);
			if ($images_url) {
				echo '<div class="gallery-block">';
				foreach ($images_url as $value) {
					echo '<div class="gallery-block-img"><img src="' . $value . '" />';
					echo '<div class="gallery-delete-img">x</div>';
					echo '</div>';
				}
				echo '</div>';
			}
			?>
			<input type="hidden" id="gallery-images-url" name="gallery-images" value="<?php echo $images_str; ?>" />
    		<input type="button" id="upload-button" class="button" value="Добавить фото" />
    		</div>
			<?php

		}


		function save_meta( $post_ID ){

			if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
				|| ( null === ( $_POST[ $this->title_slug . '_noncename' ] && $_POST[ $this->gallery_slug . '_noncename' ] )) 
				|| ( !wp_verify_nonce( $_POST[ $this->title_slug . '_noncename' ], $this->title_slug . '_dononce' ) && 
					!wp_verify_nonce( $_POST[ $this->gallery_slug . '_noncename' ], $this->gallery_slug . '_dononce' )) ) {
				return $post_ID;
			}

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
			$old = get_post_meta( $post_ID, $this->gallery_slug, true );
			$new = $_POST[ $this->gallery_slug ];

			if ($old != $new) {
				if (!$old) { 
					add_post_meta( $post_ID, $this->gallery_slug, $new, true ); 
				} elseif ( $new ) {
					update_post_meta( $post_ID, $this->gallery_slug, $new, $old );
				} else {
					delete_post_meta( $post_ID, $this->gallery_slug );
				}
			}

			return $post_ID;

		} // save_meta


		function delete_meta( $post_ID ){

			delete_post_meta( $post_ID, $this->title_slug );
			delete_post_meta( $post_ID, $this->gallery_slug );
			return $post_ID;

		} // delete_meta


    } // starck_meta_controls

    $starck_meta_controls = new starck_meta_controls;

}