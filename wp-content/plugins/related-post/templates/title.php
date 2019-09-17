<?php

if ( ! defined('ABSPATH')) exit; // if direct access 


	?>
    <div class="title">
    
    <?php 
	
	if(!empty($title_icon)){
		
		echo '<span class="fa icon '.$title_icon.'" style="font-size:'.$title_icon_font_size.';"></span> ';
		}
	

if($title_linked=='yes'){

    echo apply_filters('related_post_filter_post_title', '<a class="title" class="title" href="'.$post_link.'">'.$post_title.'</a>');
    
	}
else{

    echo apply_filters('related_post_filter_post_title', $post_title);

	}
	
    ?>
    </div>


