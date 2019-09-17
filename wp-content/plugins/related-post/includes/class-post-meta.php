<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_related_post_post_meta{
	
	public function __construct(){

		add_action('add_meta_boxes', array($this, 'meta_boxes_related_post'));
		add_action('save_post', array($this, 'meta_boxes_related_post_save'));
		
		
	}
	
	public function meta_boxes_related_post($post_type) {
		
		$post_types = array('post');
		if (in_array($post_type, $post_types)) {
		
			add_meta_box('related_post_metabox',
				__( 'Related Post', related_post_textdomain ),
				array($this, 'related_post_meta_box_function'),
				$post_type,
				'normal',
				'high'
			);
				
		}
	}
	
	public function related_post_meta_box_function($post) {
 
        wp_nonce_field('related_post_nonce_check', 'related_post_nonce_check_value');
		global $post;
		
		//$pm_related_post_meta = get_post_meta( $post->ID, 'pm_related_post_meta', true );
		$related_post_ids = get_post_meta( $post->ID, 'related_post_ids', true );		
	
		//echo '<pre>'.var_export($related_post_ids, true).'</pre>';
		
		?> 
		
		<div class="related-post-meta"> 
			
            <div class="expandable">
            
            
            	<?php
                if(!empty($related_post_ids))
				foreach( $related_post_ids as $post_id ){
					
					$post_title = get_the_title($post_id);
					
					?>
                    <div class="items">
                        <div class="header">
                            <span class="remove rt-tooltip tooltipstered"><i class="fa fa-times"></i></span>                    
                            <span class="move rt-tooltip tooltipstered"><i class="fa fa-bars"></i></span>
                            <span class="title"><?php echo $post_title; ?></span>
                            <input type="hidden" name="related_post_ids[]" value="<?php echo $post_id; ?>" />
                        </div>                       
                    </div>
                    <?php
					
					
					
					
					}
				
				?>
                 
                
            </div>
            
			<script>
             jQuery(document).ready(function($){
                 
                    $(function() {
                        $( ".expandable" ).sortable({ handle: '.move' });
                    
                    });
                    
                });
                
            </script>
        
        	<br>
			<input placeholder="Start typing..." type="text" class="related_post_get_ids" post_id="<?php echo $post->ID; ?>" name="related_post_get_ids" value="" />
        
    		<div class="suggest-post-list">
            
            </div>
            
                        
		</div> 
		
		<?php
   	}
	
	public function meta_boxes_related_post_save($post_id){
	 
		if (!isset($_POST['related_post_nonce_check_value'])) return $post_id;
		$nonce = $_POST['related_post_nonce_check_value'];
		if (!wp_verify_nonce($nonce, 'related_post_nonce_check')) return $post_id;

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	 
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) return $post_id;
		} else {
			if (!current_user_can('edit_post', $post_id)) return $post_id;
		}
	 
		//$pm_related_post_meta = stripslashes_deep( $_POST['pm_related_post_meta'] );
		
		if(!empty($_POST['related_post_ids'])){
			
			$related_post_ids = stripslashes_deep( $_POST['related_post_ids'] );
			update_post_meta( $post_id, 'related_post_ids', $related_post_ids );
			
			}
		
	

		
		// Saving the Meta Data from ARRAY
		
	}
	
} 

new class_related_post_post_meta();