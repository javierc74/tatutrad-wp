<?php

if ( ! defined('ABSPATH')) exit; // if direct access 


?>
        
        
        
<style type="text/css">

.related-post{}
.related-post .post-list{
	<?php if(!empty($grid_item_align) && $layout_type!='slider'):?>
	text-align:<?php echo $grid_item_align; ?>;
	<?php endif; ?>	
	}
.related-post .post-list .item{
	<?php if(!empty($grid_item_width) && $layout_type!='slider'):?>
	width:<?php echo $grid_item_width; ?>;
	<?php endif; ?>
	
	<?php if(!empty($grid_item_margin) && $layout_type!='slider'):?>
	margin:<?php echo $grid_item_margin; ?>;
	<?php endif; ?>	
	
	<?php if(!empty($grid_item_padding) && $layout_type!='slider'):?>
	padding:<?php echo $grid_item_padding; ?>;
	<?php endif; ?>	

	}
.related-post .post-list .item .title { 

	<?php if(!empty($title_font_size)):?>
	font-size:<?php echo $title_font_size; ?>;
	<?php endif; ?>

	<?php if(!empty($title_font_color)):?>
	color:<?php echo $title_font_color; ?>;
	<?php endif; ?>
	
	<?php if(!empty($title_line_height)):?>
	line-height:<?php echo $title_line_height; ?>;
	<?php endif; ?>

	<?php if(!empty($title_margin)):?>
	margin:<?php echo $title_margin; ?>;
	<?php endif; ?>	
	
	<?php if(!empty($title_padding)):?>
	padding:<?php echo $title_padding; ?>;
	<?php endif; ?>	


}


.related-post .post-list .item .thumb{
	

	
	<?php if(!empty($thumb_max_height)):?>
	max-height:<?php echo $thumb_max_height; ?>;
	<?php endif; ?>
	
	<?php if(!empty($thumbnail_margin)):?>
	margin:<?php echo $thumbnail_margin; ?>;
	<?php endif; ?>	
	
	<?php if(!empty($thumbnail_padding)):?>
	padding:<?php echo $thumbnail_padding; ?>;
	<?php endif; ?>	
	
	
	
	

}
.related-post .post-list .item .excerpt{

	
	<?php if(!empty($excerpt_font_size)):?>
	font-size:<?php echo $excerpt_font_size; ?>;
	<?php endif; ?>
	
	<?php if(!empty($excerpt_font_color)):?>
	color:<?php echo $excerpt_font_color; ?>;
	<?php endif; ?>		
	
	<?php if(!empty($excerpt_line_height)):?>
	line-height:<?php echo $excerpt_line_height; ?>;
	<?php endif; ?>
	
	<?php if(!empty($excerpt_margin)):?>
	margin:<?php echo $excerpt_margin; ?>;
	<?php endif; ?>	
	
	<?php if(!empty($excerpt_padding)):?>
	padding:<?php echo $excerpt_padding; ?>;
	<?php endif; ?>	
	
	
	
	}


.related-post .owl-dots .owl-dot {
	
	<?php if(!empty($slider_pagination_bg)):?>
	background:<?php echo $slider_pagination_bg; ?>;
	<?php endif; ?>	
	
	<?php if(!empty($slider_pagination_text_color)):?>
	color:<?php echo $slider_pagination_text_color; ?>;
	<?php endif; ?>	
	
	}






</style>

<?php 