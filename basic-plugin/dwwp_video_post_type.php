<?php

function dwwp_video_post_type() {

		$singular='Video';
		$plural='Videos';
  $labels = array(
    'name'               => $plural,
    'singular_name'      => $singular,
    'add_new'            => 'Add new',
    'add_new_item'       => 'Add new '.$singular,
    'edit_item'          => 'Edit '. $singular,
    'new_item'           => 'New '. $singular,
    'all_items'          => 'All '.$plural,
    'view_item'          => 'View '.$singular,
    'search_items'       => 'Search '.$singular,
    'not_found'          => 'No '. $plural. ' found',
    'not_found_in_trash' => 'No '.$plural. ' found in the Trash', 
    'parent_item_colon'  => '',
    'menu_name'          => $plural,
    
  );
  $args = array(
    'labels'        		=> $labels,
    'description'   		=> 'Holds our '.$plural.' and '.$plural.' specific data',
    'public'       			=> true,
    'menu_position'			=> 5,
    'menu_icon'   			=> 'dashicons-video-alt2',
    'supports'      		=> array( 'title', 'thumbnail'),
    'has_archive'   		=> true,
    'show_in_admin_bar'		=> true,
    'show_in_menu'			=> true,
    'can_export'			=> true,
    'delete_with_user' 		=> false,
    'hierarchical' 			=> false,
    'query_var'				=> true,
    'rewrite'				=>array('slug' => 'video',
    								'with_front' => true,
    								'pages'		=> true,
    								'feeds'		=> true,

    	),



  );
  register_post_type( 'video', $args ); 
}
add_action( 'init', 'dwwp_video_post_type' );








function my_video_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['video'] = array(
    0 => '', 
    1 => sprintf( __('Video updated. <a href="%s">View Video</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Video updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Video restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Video published. <a href="%s">View Video</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Tutorial saved.'),
    8 => sprintf( __('Video submitted. <a target="_blank" href="%s">Preview tutorial</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Video scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Video</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Video draft updated. <a target="_blank" href="%s">Preview Video</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'my_video_updated_messages' );


?>