<?php

if ( ! defined('ABSPATH')) exit; // if direct access 


$post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $thumb_size );
$thumb_url = $post_thumb['0'];


//var_dump($thumb_url );

if(!empty($thumb_url) || $thumb_url!= NULL){
	

	
		$thumb_img = '<img src="'.$thumb_url.'" />';
	}
else{
		$thumb_img = '<img src="'.$thumb_default_img.'" />';
	}



if($thumb_linked=='yes'){
	
	$thumb_img = '<a href="'.$post_link.'">'.$thumb_img.'</a>';
	}



?>

<div class="thumb">
<?php 

echo apply_filters('related_post_filter_post_thumbnail', $thumb_img);

?>
</div>

