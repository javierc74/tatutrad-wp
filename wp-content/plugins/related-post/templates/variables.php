<?php

if ( ! defined('ABSPATH')) exit; // if direct access 

$related_post_settings = get_option( 'related_post_settings' );

//echo '<pre>'.var_export($related_post_settings, true).'</pre>';
			

if(!empty($related_post_settings['slider']['column_desktop'])){
	$slider_column_number_desktop = $related_post_settings['slider']['column_desktop']; 
	
	}
else{
	$slider_column_number_desktop = 4; 
	}
	
	
if(!empty($related_post_settings['slider']['column_tablet'])){
	$slider_column_number_tablet = $related_post_settings['slider']['column_tablet']; 
	
	}	
else{
	$slider_column_number_tablet = 3; 
	}

if(!empty($related_post_settings['slider']['column_mobile'])){
	$slider_column_number_mobile = $related_post_settings['slider']['column_mobile']; 
	
	}	
else {
	$slider_column_number_mobile = 1;
	}


if(!empty($related_post_settings['slider']['auto_play'])){
	$slider_auto_play = $related_post_settings['slider']['auto_play']; 
	
	}	
else {
	$slider_auto_play = 'true';
	}	

if(!empty($related_post_settings['slider']['rewind'])){
	$slider_rewind = $related_post_settings['slider']['rewind']; 
	
	}	
else {
	$slider_rewind = 'true';
	}	

if(!empty($related_post_settings['slider']['loop'])){
	$slider_loop = $related_post_settings['slider']['loop']; 
	
	}	
else {
	$slider_loop = 'true';
	}	
	
if(!empty($related_post_settings['slider']['center'])){
	$slider_center = $related_post_settings['slider']['center']; 
	
	}	
else {
	$slider_center = 'true';
	}				
	
if(!empty($related_post_settings['slider']['stop_on_hover'])){
	$slider_stop_on_hover = $related_post_settings['slider']['stop_on_hover']; 
	}	
else {
	$slider_stop_on_hover = 'true';
	}				
	
if(!empty($related_post_settings['slider']['navigation'])){
	$slider_navigation = $related_post_settings['slider']['navigation']; 
	}	
else {
	$slider_navigation = 'true';
	}				
	
if(!empty($related_post_settings['slider']['navigation_position'])){
	$slider_navigation_position = $related_post_settings['slider']['navigation_position']; 
	}	
else {
	$slider_navigation_position = 'true';
	}				
	
if(!empty($related_post_settings['slider']['pagination'])){
	$slider_pagination = $related_post_settings['slider']['pagination']; 
	}	
else {
	$slider_pagination = 'true';
	}				
	
if(!empty($related_post_settings['slider']['pagination_bg'])){
	$slider_pagination_bg = $related_post_settings['slider']['pagination_bg']; 
	}	
else {
	$slider_pagination_bg = 'true';
	}				
	
if(!empty($related_post_settings['slider']['pagination_text_color'])){
	$slider_pagination_text_color = $related_post_settings['slider']['pagination_text_color']; 
	}	
else {
	$slider_pagination_text_color = 'true';
	}				
	
if(!empty($related_post_settings['slider']['pagination_count'])){
	$slider_pagination_count = $related_post_settings['slider']['pagination_count']; 
	}	
else {
	$slider_pagination_count = 'true';
	}				
	
	
if(!empty($related_post_settings['slider']['slide_speed'])){
	$slider_slide_speed = $related_post_settings['slider']['slide_speed']; 
	}	
else {
	$slider_slide_speed = 1000;
	}				
	
if(!empty($related_post_settings['slider']['pagination_speed'])){
	$slider_pagination_speed= $related_post_settings['slider']['pagination_speed']; 
	}	
else {
	$slider_pagination_speed = 1000;
	}				
	
	
if(!empty($related_post_settings['slider']['touch_drag'])){
	$slider_touch_drag= $related_post_settings['slider']['touch_drag']; 
	}	
else {
	$slider_touch_drag = 'true';
	}				
					
if(!empty($related_post_settings['slider']['mouse_drag'])){
	$slider_mouse_drag= $related_post_settings['slider']['mouse_drag']; 
	}	
else {
	$slider_mouse_drag = 'true';
	}				
	
	
if(!empty($related_post_settings['slider']['rtl'])){
	$slider_rtl= $related_post_settings['slider']['rtl']; 
	}	
else {

	$slider_rtl = 'true';
	}	
	
	
if(!empty($related_post_settings['layout_type'])){
	$layout_type= $related_post_settings['layout_type']; 
	}	
else {

	$layout_type = 'grid';
	}				
	
if(!empty($related_post_settings['display_auto'])){
	$display_auto= $related_post_settings['display_auto']; 
	}	
else {

	$display_auto = 'yes';
	}					
	
	
if(!empty($related_post_settings['post_types'])){
	$post_types= $related_post_settings['post_types']; 
	}	
else {

	$post_types = array('post'=>1);
	}	
								
	
if(!empty($related_post_settings['max_post_count'])){
	$max_post_count= $related_post_settings['max_post_count']; 
	}	
else {

	$max_post_count = 5;
	}				

if(!empty($related_post_settings['headline_text'])){
	$headline_text= $related_post_settings['headline_text']; 
	}	
else {

	$headline_text = '';
	}	
	
	
if(!empty($related_post_settings['grid_item_width'])){
	$grid_item_width= $related_post_settings['grid_item_width']; 
	}	
else {

	$grid_item_width = '';
	}					
	
	
if(!empty($related_post_settings['grid_item_margin'])){
	$grid_item_margin= $related_post_settings['grid_item_margin']; 
	}	
else {

	$grid_item_margin = '';
	}				
	
	
if(!empty($related_post_settings['grid_item_padding'])){
	$grid_item_padding= $related_post_settings['grid_item_padding']; 
	}	
else {

	$grid_item_padding = '';
	}
	
if(!empty($related_post_settings['grid_item_align'])){
	$grid_item_align= $related_post_settings['grid_item_align']; 
	}	
else {

	$grid_item_align = 'left';
	}	
	
	
	
if(!empty($related_post_settings['layout_items'])){
	$layout_items= $related_post_settings['layout_items']; 
	}	
else {

	$layout_items = '';
	}				


if(!empty($related_post_settings['layout_items']['title']['options']['font_size'])){
	$title_font_size= $related_post_settings['layout_items']['title']['options']['font_size']; 
	}	
else {

	$title_font_size = '16px';
	}	

if(!empty($related_post_settings['layout_items']['title']['options']['font_color'])){
	$title_font_color= $related_post_settings['layout_items']['title']['options']['font_color']; 
	}	
else {

	$title_font_color = '#999';
	}	


if(!empty($related_post_settings['layout_items']['title']['options']['line_height'])){
	$title_line_height= $related_post_settings['layout_items']['title']['options']['line_height']; 
	}	
else {

	$title_line_height = 'normal';
	}	

if(!empty($related_post_settings['layout_items']['title']['options']['title_linked'])){
	$title_linked= $related_post_settings['layout_items']['title']['options']['title_linked']; 
	}	
else {

	$title_linked = 'yes';
	}	



if(!empty($related_post_settings['layout_items']['title']['options']['margin'])){
	$title_margin = $related_post_settings['layout_items']['title']['options']['margin']; 
	}	
else {

	$title_margin = '';
	}	

if(!empty($related_post_settings['layout_items']['title']['options']['padding'])){
	$title_padding = $related_post_settings['layout_items']['title']['options']['padding']; 
	}	
else {

	$title_padding = '';
	}


if(!empty($related_post_settings['layout_items']['title']['options']['icon'])){
	$title_icon = $related_post_settings['layout_items']['title']['options']['icon']; 
	}	
else {

	$title_icon = '';
	}


if(!empty($related_post_settings['layout_items']['title']['options']['icon_font_size'])){
	$title_icon_font_size = $related_post_settings['layout_items']['title']['options']['icon_font_size']; 
	}	
else {

	$title_icon_font_size = '';
	}





if(!empty($related_post_settings['layout_items']['thumbnail']['options']['thumb_size'])){
	$thumb_size= $related_post_settings['layout_items']['thumbnail']['options']['thumb_size']; 
	}	
else {

	$thumb_size = '';
	}



if(!empty($related_post_settings['layout_items']['thumbnail']['options']['default_img'])){
	$thumb_default_img= $related_post_settings['layout_items']['thumbnail']['options']['default_img']; 
	}	
else {

	$thumb_default_img = '';
	}

if(!empty($related_post_settings['layout_items']['thumbnail']['options']['thumb_linked'])){
	$thumb_linked= $related_post_settings['layout_items']['thumbnail']['options']['thumb_linked']; 
	}	
else {

	$thumb_linked = 'yes';
	}

if(!empty($related_post_settings['layout_items']['thumbnail']['options']['max_height'])){
	$thumb_max_height= $related_post_settings['layout_items']['thumbnail']['options']['max_height']; 
	}	
else {

	$thumb_max_height = '180px';
	}


if(!empty($related_post_settings['layout_items']['thumbnail']['options']['margin'])){
	$thumbnail_margin = $related_post_settings['layout_items']['thumbnail']['options']['margin']; 
	}	
else {

	$thumbnail_margin = '';
	}	

if(!empty($related_post_settings['layout_items']['thumbnail']['options']['padding'])){
	$thumbnail_padding = $related_post_settings['layout_items']['thumbnail']['options']['padding']; 
	}	
else {

	$thumbnail_padding = '';
	}




if(!empty($related_post_settings['layout_items']['excerpt']['options']['font_size'])){
	$excerpt_font_size= $related_post_settings['layout_items']['excerpt']['options']['font_size']; 
	}	
else {

	$excerpt_font_size = '13px';
	}

if(!empty($related_post_settings['layout_items']['excerpt']['options']['font_color'])){
	$excerpt_font_color= $related_post_settings['layout_items']['excerpt']['options']['font_color']; 
	}	
else {

	$excerpt_font_color = '#999';
	}

if(!empty($related_post_settings['layout_items']['excerpt']['options']['line_height'])){
	$excerpt_line_height= $related_post_settings['layout_items']['excerpt']['options']['line_height']; 
	}	
else {

	$excerpt_line_height = 'normal';
	}
	
if(!empty($related_post_settings['layout_items']['excerpt']['options']['word_count'])){
	$excerpt_word_count= $related_post_settings['layout_items']['excerpt']['options']['word_count']; 
	}	
else {

	$excerpt_word_count = '15';
	}
	
if(!empty($related_post_settings['layout_items']['excerpt']['options']['read_more_text'])){
	$excerpt_read_more_text= $related_post_settings['layout_items']['excerpt']['options']['read_more_text']; 
	}	
else {

	$excerpt_read_more_text = '';
	}				
	
	
	
if(!empty($related_post_settings['layout_items']['excerpt']['options']['margin'])){
	$excerpt_margin = $related_post_settings['layout_items']['excerpt']['options']['margin']; 
	}	
else {

	$excerpt_margin = '';
	}	

if(!empty($related_post_settings['layout_items']['excerpt']['options']['padding'])){
	$excerpt_padding = $related_post_settings['layout_items']['excerpt']['options']['padding']; 
	}	
else {

	$excerpt_padding = '';
	}
		
if(!empty($related_post_settings['enable_stats'])){
	$enable_stats = $related_post_settings['enable_stats']; 
	}	
else {

	$enable_stats = 'disable';
	}
		
		
		
		
		
		
		
				
