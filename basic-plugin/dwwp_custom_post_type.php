<?php

function dwwp_custom_post_type() {

		$singular='Tutorial';
		$plural='Tutorials';
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
    'taxonomies'  			=> array( 'topics' ),
    'description'   		=> 'Holds our tutorials and tutorials specific data',
    'public'       			=> true,
    'menu_position'			=> 5,
    'menu_icon'   			=> 'dashicons-book',
    'supports'      		=> array( 'title', 'editor','thumbnail'),
    'has_archive'   		=> true,
    'show_in_admin_bar'		=> true,
    'show_in_menu'			=> true,
    'can_export'			=> true,
    'delete_with_user' 		=> false,
    'hierarchical' 			=> false,
    'query_var'				=> true,
    'rewrite'				=>array('slug' => 'tutorial',
    								'with_front' => true,
    								'pages'		=> true,
    								'feeds'		=> true,

    	),



  );
  register_post_type( 'tutorial', $args ); 
}
add_action( 'init', 'dwwp_custom_post_type' );








function my_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['tutorial'] = array(
    0 => '', 
    1 => sprintf( __('Tutorial updated. <a href="%s">View Tutorial</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Product updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Tutorial restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Tutorial published. <a href="%s">View tutorial</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Tutorial saved.'),
    8 => sprintf( __('Tutorial submitted. <a target="_blank" href="%s">Preview tutorial</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Tutorial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Tutorial</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Tutorial draft updated. <a target="_blank" href="%s">Preview Tutorial</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );





//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'dwwp_topics_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts

function dwwp_topics_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

  $labels = array(
    'name' => _x( 'Topics', 'taxonomy general name' ),
    'singular_name' => _x( 'Topic', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Topics' ),
    'all_items' => __( 'All Topics' ),
    'parent_item' => __( 'Parent Topic' ),
    'parent_item_colon' => __( 'Parent Topic:' ),
    'edit_item' => __( 'Edit Topic' ), 
    'update_item' => __( 'Update Topic' ),
    'add_new_item' => __( 'Add New Topic' ),
    'new_item_name' => __( 'New Topic Name' ),
    'menu_name' => __( 'Topics' ),
  ); 	

// Now register the taxonomy

  register_taxonomy('topics',array('tutorial'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'topic' ),
  ));

}

?>