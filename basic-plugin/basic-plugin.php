<?php
/*
	Plugin Name: Basic Plugin
	Plugin URI: http://developervivek.ml
	Description:A plugin for creating and displaying job opertunities.
	Author:Vivek Vijayan
	Version:1.0.0
	Licence:GPLv2
*/
	if(!defined('ABSPATH')){
		exit;
	}
	require_once (plugin_dir_path(__FILE__).'dwwp_custom_post_type.php');
	require_once (plugin_dir_path(__FILE__).'dwwp_custom_meta_fields.php');
	require_once (plugin_dir_path(__FILE__).'dwwp_video_post_type.php');
	require_once (plugin_dir_path(__FILE__).'dwwp_video_meta_fields.php');

	function dwwp_admin_enqueue_scripts(){

		global $pagenow,$typenow;
		$screen=get_current_screen();
		if( ($pagenow == 'post.php' || $pagenow = 'post-new.php' )&& $typenow == 'tutorial' )
		{
			wp_enqueue_style('dwwp-admin-css',plugins_url('css/plugin_style.css', __FILE__ ));
			wp_enqueue_style('dwwp-admin-css',plugins_url('css/jquery-ui.css', __FILE__ ));
			wp_enqueue_script('dwwp-custom_quicktags',includes_url('js/quicktags.min.js.', __FILE__ ));
			wp_enqueue_script('dwwp-admin-js',plugins_url('js/plugin_custom.js', __FILE__ ),array('jquery','jquery-ui-datepicker'),'20150204');
			
		}

	}
	add_action('admin_enqueue_scripts','dwwp_admin_enqueue_scripts');







	function dwwp_remove_dashboard_widget(){

		remove_meta_box( 'dashboard_primary','dashboard', 'side' );
	}

	add_action('wp_dashboard_setup','dwwp_remove_dashboard_widget');

	function dwwp_add_google_link(){

		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array(

					'id'	 => 'google_analytics',
					'title'  => 'Google Analytics',
					'href'   => 'http://google.com/analytics'

			) );
	}
	add_action('wp_before_admin_bar_render','dwwp_add_google_link');



	add_action('publish_post','dwwp_custom_tag');

	function dwwp_custom_tag(){

		$post_ID=get_the_ID();
		$tags=array('valiyathara','test tag','active');
		wp_set_post_tags($post_ID,$tags,true);
	}


	register_activation_hook( __FILE__, 'dwwp_create_db' );
	function dwwp_create_db() {

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'my_analysis';

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			views smallint(5) NOT NULL,
			clicks smallint(5) NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	
	}
?>