<?php

	function dwwp_add_custom_meta_box(){

		add_meta_box(
			'dwwp_meta_author', //unique Id
			'Author Details', //Title
			'dwwp_meta_callback',// callback
			'tutorial', //post type
			'side',//context
			'low'//priority
			);
	}
	add_action('add_meta_boxes','dwwp_add_custom_meta_box');


		function dwwp_meta_callback($post){

			wp_nonce_field( basename( __FILE__ ), 'dwwp_tutorial_nonce');
			$dwwp_stored_meta=get_post_meta($post->ID);

			//var_dump($dwwp_stored_meta);
			
?>

	<div class="meta row col-md-12">
	<div class="cust_meta_block col-md-12">
	<div class="mata-th">
		<label for="author_name" class="dwwp-row-title"> Author Name</label>
	</div>
	<input type="text" name="author_name" id="author_name" style="width:100%" value="<?php if(!empty( $dwwp_stored_meta['author_name'])) echo esc_attr($dwwp_stored_meta['author_name'][0]) ?>"/>
	</div>
	<div class="cust_meta_block col-md-12">
	<div class="mata-th">
		<label for="about_author" class="dwwp-row-title">About the Author</label>
	</div>
	<textarea  name="about_author" id="about_author" rows="5" style="width:100%"><?php if(!empty( $dwwp_stored_meta['about_author'])) echo esc_attr($dwwp_stored_meta['about_author'][0]) ?>
	</textarea>
	</div>
	</div>


<?php

		}


	function dwwp_meta_save($post_id){


			$is_autosave=wp_is_post_autosave($post_id);
			$is_revision=wp_is_post_revision($post_id);

			$is_valid_nonce=(isset($_POST['dwwp_tutorial_nonce'])  && wp_verify_nonce( $_POST['dwwp_tutorial_nonce'], basename( __FILE__ ) ) ) ? 'true' : 'false';

			if( $is_autosave || $is_revision || !$is_valid_nonce ){
				return;
			}

			if(isset($_POST['author_name'])){
				update_post_meta($post_id,'author_name',sanitize_text_field($_POST['author_name']));

			}

			if(isset($_POST['about_author'])){
				update_post_meta($post_id,'about_author',sanitize_text_field($_POST['about_author']));

			}
	}
	add_action('save_post','dwwp_meta_save');
?>