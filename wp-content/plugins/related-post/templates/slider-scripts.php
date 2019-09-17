<?php

if ( ! defined('ABSPATH')) exit; // if direct access 

if($layout_type=='slider'):
?>
<script>
jQuery(document).ready(function($)
	{
		$(".related-post .post-list").owlCarousel({
			
			items :<?php echo $slider_column_number_desktop; ?>,
			responsiveClass:true,
			
			responsive:{
				0:{
					items:<?php echo $slider_column_number_mobile; ?>,
					
				},
				600:{
					items:<?php echo $slider_column_number_mobile; ?>,
					
				},
				
				900:{
					items:<?php echo $slider_column_number_tablet; ?>,
					
				},				
				
				1000:{
					items:<?php echo $slider_column_number_desktop; ?>,
					
					
				}
			},
			
			<?php if(!empty($slider_rewind)): ?>
			rewind: <?php echo $slider_rewind; ?>,
			<?php endif;?>	
			
			<?php if(!empty($slider_loop)): ?>
			loop: <?php echo $slider_loop; ?>,
			<?php endif;?>
			
			<?php if(!empty($slider_center)): ?>
			center: <?php echo $slider_center; ?>,
			<?php endif;?>		
			
			
			<?php if(!empty($slider_auto_play)): ?>
			autoplay: <?php echo $slider_auto_play; ?>,
			autoplayHoverPause: <?php echo $slider_stop_on_hover; ?>,
			<?php endif;?>				
			
			<?php if(!empty($slider_navigation)): ?>
			nav: <?php echo $slider_navigation; ?>,
			navSpeed: <?php echo $slider_slide_speed; ?>,
			navText : ["",""],
			<?php endif;?>				
			
			
			<?php if(!empty($slider_pagination)): ?>
			dots: <?php echo $slider_pagination; ?>,
			dotsSpeed: <?php echo $slider_pagination_speed; ?>,
			navText : ["",""],
			<?php endif;?>				
			
			
			<?php if(!empty($slider_touch_drag)): ?>
			touchDrag: <?php echo $slider_touch_drag; ?>,
			<?php endif;?>			
			
			<?php if(!empty($slider_mouse_drag)): ?>
			mouseDrag: <?php echo $slider_mouse_drag; ?>,
			<?php endif;?>	
			
			<?php if(!empty($slider_rtl)): ?>
			rtl: <?php echo $slider_rtl; ?>,
			<?php endif;?>						
	
		});
	});
</script>
<?php
endif;