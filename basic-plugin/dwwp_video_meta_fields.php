<?php

	function dwwp_add_video_meta_box(){

		add_meta_box(
			'dwwp_meta_video', //unique Id
			'Video Details', //Title
			'dwwp_meta_video_callback',// callback
			'video', //post type
			'normal',//context
			'low'//priority
			);
	}
	add_action('add_meta_boxes','dwwp_add_video_meta_box');


		function dwwp_meta_video_callback($post){

			wp_nonce_field( basename( __FILE__ ), 'dwwp_video_nonce');
			$dwwp_stored_meta=get_post_meta($post->ID);

			//var_dump($dwwp_stored_meta);
			
?>

	<div class="meta row col-md-12">
	<div class="cust_meta_block col-md-12">
	<div class="mata-th">
		<label for="video_url" class="dwwp-row-title"> Video url</label>
	</div>
	<input type="text" name="video_url" id="video_url" style="width:100%" value="<?php if(!empty( $dwwp_stored_meta['video_url'])) echo esc_attr($dwwp_stored_meta['video_url'][0]) ?>"/>
	</div>
	</div>


<?php

		}


	function dwwp_meta_video_save($post_id){


			$is_autosave=wp_is_post_autosave($post_id);
			$is_revision=wp_is_post_revision($post_id);

			$is_valid_nonce=(isset($_POST['dwwp_video_nonce'])  && wp_verify_nonce( $_POST['dwwp_video_nonce'], basename( __FILE__ ) ) ) ? 'true' : 'false';

			if( $is_autosave || $is_revision || !$is_valid_nonce ){
				return;
			}

			if(isset($_POST['video_url'])){
				update_post_meta($post_id,'video_url',sanitize_text_field($_POST['video_url']));

			}
	}
	add_action('save_post','dwwp_meta_video_save');
?>