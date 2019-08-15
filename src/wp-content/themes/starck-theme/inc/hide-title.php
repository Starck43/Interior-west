<?php
/*
Plugin Name: Hide Title
Description: Allows to hide the title on single pages and posts via edit mode.
Version: 1.0.0
Author: S.Shabalin
*/

if ( !class_exists( 'starck_hide_title' ) ) {

    class starck_hide_title {

    	private $slug = 'starck-hide-title';

        /**
        * PHP 5 Constructor
        */
        function __construct(){

	        add_action( 'add_meta_boxes', array( $this, 'add_section' ) );
			add_action( 'save_post', array( $this, 'save_meta' ) );
			add_action( 'delete_post', array( $this, 'delete_meta' ) );

        } // __construct()



 		function add_section(){

			add_meta_box( $this->slug, 'Title', array( $this, 'metabox_callback' ), array( 'post', 'page' ), 'side', 'default' );

		}


		function metabox_callback( $post ){

			$value = get_post_meta( $post->ID, $this->slug, true );

			$checked = '';

			if ( (bool)$value ) { $checked = ' checked="checked"'; }

			wp_nonce_field( $this->slug . '_dononce', $this->slug . '_noncename' );

			?>
			<label><input type="checkbox" name="<?php echo $this->slug; ?>" <?php echo $checked; ?> />Скрыть заголовок</label>
			<?php

		}


		function save_meta( $post_ID ){

			if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
				|| !isset( $_POST[ $this->slug . '_noncename' ] )
				|| !wp_verify_nonce( $_POST[ $this->slug . '_noncename' ], $this->slug . '_dononce' ) ) {
				return $post_ID;
			}

			$old = get_post_meta( $post_ID, $this->slug, true );
			$new = $_POST[ $this->slug ] ;

			if( $old ){
				if ( $new ){
					update_post_meta( $post_ID, $this->slug, $new, $old );
				} else {
					delete_post_meta( $post_ID, $this->slug );
				}
			} elseif ( !is_null( $new ) ) {
				add_post_meta( $post_ID, $this->slug, $new, true );
			}

			return $post_ID;

		} // save_meta


		function delete_meta( $post_ID ){
			delete_post_meta( $post_ID, $this->slug );
			return $post_ID;
		} // delete_meta


    } // starck_hide_title

    $starck_hide_title = new starck_hide_title;

}