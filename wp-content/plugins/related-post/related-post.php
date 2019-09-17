<?php
/*
Plugin Name: Related Post
Plugin URI: 
Description: Display Related Post under post by tags and category.
Version: 2.0.4
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



class RelatedPost{
	
	public function __construct(){
		
		
		define('related_post_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
		define('related_post_plugin_dir', plugin_dir_path( __FILE__ ) );
		define('related_post_wp_url', 'http://wordpress.org/plugins/related-post/' );
		define('related_post_pro_url', '' );
		define('related_post_demo_url', '' );
		define('related_post_conatct_url', 'http://pickplugins.com/contact' );
		define('related_post_qa_url', 'http://pickplugins.com/questions' );
		define('related_post_plugin_name', 'Related Post' );
		define('related_post_share_url', 'http://wordpress.org/plugins/related-post/' );
		define('related_post_textdomain', 'related-post' );

		require_once( plugin_dir_path( __FILE__ ) . 'includes/class-settings.php');
		require_once( plugin_dir_path( __FILE__ ) . 'includes/class-functions.php');
		require_once( plugin_dir_path( __FILE__ ) . 'includes/class-notices.php');				
		require_once( plugin_dir_path( __FILE__ ) . 'includes/class-post-meta.php');				
		require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php');
		require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php');
		
		
		//Themes php files


		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' ); 
		add_action( 'wp_enqueue_scripts', array( $this, 'related_post_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'related_post_admin_scripts' ) );


		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));
		
		
		register_activation_hook( __FILE__, array( $this, '_activation' ) );
		
		}
	
	
	public function _activation() {
		
		
		
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table = $wpdb->prefix .'related_post_stats';
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$table ." (
			id int(100) NOT NULL AUTO_INCREMENT,
			from_id int(100) NOT NULL,
			to_id int(100) NOT NULL,
			date DATE NOT NULL,		
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		
		dbDelta( $sql );	
		
		
		
		
		
		
		
			
			$related_post_review_settings = get_option('related_post_review_settings');
			
			if(empty($related_post_review_settings)):
			
				$related_post_display = get_option( 'related_post_display' );	
				$related_post_display_themes = get_option( 'related_post_display_themes' );
				$related_post_display_posttype = get_option( 'related_post_display_posttype' );						
				$related_post_max_number = get_option( 'related_post_max_number' );	
				$related_post_headline = get_option( 'related_post_headline' );
				$related_post_title_font_size = get_option( 'related_post_title_font_size' );
				$related_post_title_font_color = get_option( 'related_post_title_font_color' );	
				$related_post_thumb_size = get_option( 'related_post_thumb_size' );					
				$related_post_404_img_src = get_option( 'related_post_404_img_src' );
			
				
				$related_post_settings = array(
												'display_auto'=>$related_post_display,
												'post_types'=>$related_post_display_posttype,
												'max_post_count'=>$related_post_max_number,
												'headline_text'=>$related_post_headline,
												'layout_items'=>array(
																	'thumbnail'=> array (
																					  'name' => 'Thumbnail',
																					  'options' => 
																					  array (
																						'thumb_size' => $related_post_thumb_size,
																						'default_img' => $related_post_404_img_src,
																						'thumb_linked' => 'yes',
																						'max_height' => '180px',
																						'margin' => '',
																						'padding' => '',
																					  ),
																					),
																	'title'=> array (
																					  'name' => 'Title',
																					  'options' => 
																					  array (
																						'font_size' => $related_post_title_font_size,
																						'font_color' => $related_post_title_font_color,
																						'line_height' => 'normal',
																						'title_linked' => 'yes',
																						'margin' => '',
																						'padding' => '',
																					  ),
																					),
																	'excerpt'=> array (
																					  'name' => 'Excerpt',
																					  'options' => 
																					  array (
																						'font_size' => '13px',
																						'font_color' => '#999',
																						'line_height' => 'normal',
																						'word_count' => '15',
																						'read_more_text' => '',
																						'margin' => '',
																						'padding' => '',
																					  ),
																					),
																	
																	),
											
											);
			
				update_option('related_post_settings', $related_post_settings);	
			
			
			endif;
			

		
		
		
		}
	
	
	
	public function load_textdomain() {
	  load_plugin_textdomain( related_post_textdomain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' ); 
	}
	
	
	
	function related_post_front_scripts(){
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('related_post_js', plugins_url( '/assets/front/js/related-post-scripts.js' , __FILE__ ) , array( 'jquery' ));	
		
		
		wp_localize_script('related_post_js', 'related_post_ajax', array( 'related_post_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_style('related-post', related_post_plugin_url.'assets/front/css/related-post.css');
		wp_enqueue_style('related-post-style', related_post_plugin_url.'assets/front/css/style.css');
		wp_enqueue_style('font-awesome', related_post_plugin_url.'assets/front/css/font-awesome.min.css');		
		
		wp_enqueue_style('font-awesome', plugins_url( 'assets/front/css/font-awesome.min.css', __FILE__ ));
		
		wp_enqueue_script('owl.carousel.min', plugins_url( '/assets/front/js/owl.carousel.min.js' , __FILE__ ) , array( 'jquery' ));		
		wp_enqueue_style('owl.carousel', related_post_plugin_url.'assets/front/css/owl.carousel.css');

		
		// Style for themes
		//wp_enqueue_style('related-post-style-text', related_post_plugin_url.'themes/text/style.css');
		//wp_enqueue_style('related-post-style-flat', related_post_plugin_url.'themes/flat/style.css');
		//wp_enqueue_style('related-post-style-box', related_post_plugin_url.'themes/box/style.css');
		//wp_enqueue_style('related-post-style-vertical', related_post_plugin_url.'themes/vertical/style.css');
		
	}
	
	
	function related_post_admin_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		
		// Color Picker
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script('wp-color-picker');
		
		wp_enqueue_script('related_post_js', plugins_url( 'assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script('related_post_js', 'related_post_ajax', array( 'related_post_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		wp_enqueue_script('expandable', plugins_url( 'assets/admin/js/expandable.js' , __FILE__ ) , array( 'jquery' ));	
	
		wp_enqueue_style('related-post-admin-style', related_post_plugin_url.'assets/admin/css/style.css');
		wp_enqueue_style('font-awesome', related_post_plugin_url.'assets/front/css/font-awesome.min.css');
		
		wp_enqueue_style('related-post-expandable', related_post_plugin_url.'assets/admin/css/expandable.css');
		
		
		
		//ParaAdmin framwork
		wp_enqueue_style('ParaAdmin', related_post_plugin_url.'assets/admin/ParaAdmin/css/ParaAdmin.css');	
		//wp_enqueue_script('ParaAdmin', plugins_url( 'assets/admin/ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));	
	

		
	
	
	}
	
	
	
}

new RelatedPost();



