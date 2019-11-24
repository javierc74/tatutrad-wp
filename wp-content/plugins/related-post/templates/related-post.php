<?php

if ( ! defined('ABSPATH')) exit; // if direct access 



include( related_post_plugin_dir . 'templates/variables.php');


/*

if(!empty($post_types)){
	
		$type = '';
		
		foreach ( $post_types as  $post_type => $post_type_value ){
		
			$type.= $post_type.",";
			
			}
	}

*/



		$post_id = get_the_ID();
		$post_type = get_post_type( get_the_ID() );	
		$post_ids = get_post_ids_by_taxonomy_terms();

		$related_post_ids = get_post_meta( $post_id, 'related_post_ids', true );



		//echo '<pre>'.var_export($post_id, true).'</pre>';		
		//echo '<pre>'.var_export($related_post_ids, true).'</pre>';
		if(!empty($related_post_ids))
		$post_ids = array_merge($related_post_ids, $post_ids);

		//echo '<pre>'.var_export($post_ids, true).'</pre>';

		if(!empty($post_ids)){

				echo '<div  class="related-post '.$layout_type.'" >';
				if(!empty($headline_text)){
					echo '<div  class="headline" >'.$headline_text.'</div>';
					}
		
					
				if($layout_type=='slider'){
					$slider_class = 'owl-carousel';
					
					}
				else{
					$slider_class = '';
					}

					
				echo '<div class="post-list '.$slider_class.'">';

				$args = array('post_type' => $post_type,
                    'post_status' => 'publish',
                    'post__in'=> $post_ids,
                    'post__not_in' => $post_id,
                    'orderby' => $orderby,
                    'order' => $order,
                    'showposts' => $max_post_count,
                    'ignore_sticky_posts' => 1);
				

				$wp_query = new WP_Query($args);	
				
				if ($wp_query->have_posts()){
						
						while ($wp_query->have_posts()) : $wp_query->the_post();
							
							
							$post_link = get_permalink(get_the_ID());
							$post_title = get_the_title(get_the_ID());
						
							if($enable_stats=='enable'){
								$post_link = $post_link.'?to_id='.get_the_ID().'&from_id='.$post_id;
								}
						
						
							echo '<div class="item">';
							
							if(!empty($layout_items))
							foreach($layout_items as $item_key=>$item){
							
								if(empty($item['options']['hide']))
								include( related_post_plugin_dir . 'templates/'.$item_key.'.php');
								
								}
							
							echo '</div> <!-- .item -->';
						
						endwhile; 
						//wp_reset_query(); 
						wp_reset_postdata(); 
					}
								
					echo '</div><!-- .post-list -->';	
								
				echo '</div><!-- .related-post -->';				
								
								
				include( related_post_plugin_dir . 'templates/css.php');
				include( related_post_plugin_dir . 'templates/slider-scripts.php');					
								
			}

	






