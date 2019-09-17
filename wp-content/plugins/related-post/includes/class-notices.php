<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

class class_related_post_notices{

    public function __construct(){

		add_action( 'admin_notices', array( $this, 'review_settings' ), 12 );

		}

	public function review_settings(){

			if(!empty($_POST['related_post_settings'])){
				
				update_option('related_post_review_settings', 'yes');
				
				}
		
			$related_post_review_settings = get_option('related_post_review_settings');
		
		
			$html= '';

			if($related_post_review_settings!='yes'){
				
					$admin_url = get_admin_url();
					
					$html.= '<div class="update-nag">';
					$html.= sprintf(__('We have update lots more things, Please review settings <a href="%sadmin.php?page=related_post_settings">Related Post</a>', related_post_textdomain), $admin_url);
					$html.= '</div>';	
				}


			echo $html;
							
		
		}


	}
	
new class_related_post_notices();