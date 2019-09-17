<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

class class_related_post_settings{

    public function __construct(){

		add_action( 'admin_menu', array( $this, 'related_post_menu_init' ), 12 );

		}



	
	public function settings(){
		include('menu/settings.php');	
		}

	public function help(){
		include('menu/help.php');	
		}
	public	function related_post_menu_init(){

		
		
		add_menu_page(__('Related Post','related-post'), __('Related Post','related-post'), 'manage_options', 'related_post_settings', array( $this, 'settings' ));
		add_submenu_page('related_post_settings', __('Help & Contact','related-post'), __('Help & Contact','related-post'), 'manage_options', 'related_post_help', array( $this, 'help' ));
		}






	}
	
new class_related_post_settings();