<?php	


if ( ! defined('ABSPATH')) exit; // if direct access 



	if(empty($_POST['related_post_hidden'])){
	
			$related_post_settings = get_option( 'related_post_settings' );		
			
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


        $orderby= isset($related_post_settings['orderby']) ? $related_post_settings['orderby'] : 'date';
        $order = isset($related_post_settings['order']) ? $related_post_settings['order'] : 'DESC';




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
				$grid_item_align = $related_post_settings['grid_item_align']; 
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
			
		
				
						
		
			
		}
	else
		{	
			if($_POST['related_post_hidden'] == 'Y') {
				//Form data sent
				
				
			
			$related_post_settings = stripslashes_deep($_POST['related_post_settings']);
			update_option('related_post_settings', $related_post_settings);	
				
			
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

                $orderby= isset($related_post_settings['orderby']) ? $related_post_settings['orderby'] : 'date';
                $order = isset($related_post_settings['order']) ? $related_post_settings['order'] : 'DESC';


				
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
				
			if(!empty($related_post_settings['grid_item_padding'])){
				$grid_item_padding= $related_post_settings['grid_item_padding']; 
				}	
			else {

				$grid_item_padding = '';
				}				
				
			if(!empty($related_post_settings['grid_item_align'])){
				$grid_item_align = $related_post_settings['grid_item_align']; 
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
				
				
				
				
				
				
	
		

				?>
				<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p></div>
		
				<?php
				} 
		}
?>





<div class="wrap related-post-admin">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(related_post_plugin_name.' Settings')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="related_post_hidden" value="Y">
        <?php settings_fields( 'related_post_plugin_options' );
				do_settings_sections( 'related_post_plugin_options' );
			
		?>

    <div class="para-settings ">
    
        <ul class="tab-nav">
            <li nav="1" class="nav1 active">Options</li>
            <li nav="2" class="nav2">Style & Layout</li>            
            <li nav="3" class="nav3">Slider Options</li>
            <li nav="4" class="nav4">Short-Codes</li>
            <li nav="5" class="nav5">Stats</li> 
        </ul> <!-- tab-nav end -->   
    
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
            
				<div class="option-box">
                    <p class="option-title">Display automatically.</p>
                    <p class="option-info">Related post will display based on terms and taxonomy under post content.</p>
                    <select name="related_post_settings[display_auto]" >
                    	<option value="yes" <?php if($display_auto=="yes")echo "selected"; ?> >Yes</option>
                        <option value="no" <?php if($display_auto=="no")echo "selected"; ?> >No</option>
                    
                    </select>
                </div>  
                
                
                
                
                
                
                
                
                
                
				<div class="option-box">
                    <p class="option-title">Display automaticaly only these post types</p>
                    <p class="option-info">Selected post type will display automaticaly related post based on terms and taxonomy.</p>
					<?php
                    
                    $post_types_list = get_post_types( '', 'names' ); 
                    
					//echo '<pre>'.var_export($post_types, true).'</pre>';
					//$post_types = array_merge(array('none'=>'None'), $post_types);
					
                    foreach ( $post_types_list as $post_type ) {
                    
						$obj = get_post_type_object( $post_type );
						$singular_name = $obj->labels->singular_name;
					
					
                       echo '<label ><input type="checkbox" name="related_post_settings[post_types]['.$post_type.']"  value ="1" ' ?> 
                       <?php if ( isset( $post_types[$post_type] ) ) echo "checked"; ?>
                       <?php echo' >'. $singular_name.'</label><br />' ;
                    }
                    ?>

                </div>


                <div class="option-box">
                    <p class="option-title">Post orderby.</p>
                    <p class="option-info"></p>


                    <select name="related_post_settings[orderby]">
                        <option value="none" <?php if($orderby=="none")echo "selected"; ?>>None</option>
                        <option value="ID" <?php if($orderby=="ID")echo "selected"; ?>>ID</option>
                        <option value="date" <?php if($orderby=="date")echo "selected"; ?>>Date</option>
                        <option value="rand" <?php if($orderby=="rand")echo "selected"; ?>>Rand</option>
                        <option value="comment_count" <?php if($orderby=="comment_count")echo "selected"; ?>>Comment Count</option>
                        <option value="author" <?php if($orderby=="author")echo "selected"; ?>>Author</option>
                        <option value="title" <?php if($orderby=="title")echo "selected"; ?>>Title</option>
                        <option value="name" <?php if($orderby=="name")echo "selected"; ?>>Name</option>
                        <option value="type" <?php if($orderby=="type")echo "selected"; ?>>Type</option>
                        <option value="menu_order" <?php if($orderby=="menu_order")echo "selected"; ?>>Menu order</option>
                        <option value="post__in" <?php if($orderby=="post__in")echo "selected"; ?>>post__in</option>


                    </select>

                </div>

                <div class="option-box">
                    <p class="option-title">Post order.</p>
                    <p class="option-info"></p>
                    <select name="related_post_settings[order]" >
                        <option value="DESC" <?php if($order=="DESC")echo "selected"; ?> >DESC</option>
                        <option value="ASC" <?php if($order=="ASC")echo "selected"; ?> >ASC</option>

                    </select>
                </div>




                <div class="option-box">
                    <p class="option-title">Maximum number of post to display</p>
                    <p class="option-info"></p>
                    <input placeholder="4" type="text" name="related_post_settings[max_post_count]" value="<?php if(!empty($max_post_count)) echo $max_post_count; ?>" />

                </div>            
            
				<div class="option-box">
                    <p class="option-title">Head line text</p>
                    <p class="option-info"></p>
                    <input placeholder="Related Posts..." type="text" name="related_post_settings[headline_text]" value="<?php if(!empty($headline_text)) echo $headline_text; ?>" />

                </div>
            </li>
            <li style="display: none;" class="box2 tab-box"> 
            
            
				<div class="option-box">
                    <p class="option-title">Layout type</p>
                    <p class="option-info"></p>
                    <select name="related_post_settings[layout_type]" >
                    	<option value="grid" <?php if($layout_type=="grid")echo "selected"; ?> >Grid</option>
                    	<option value="slider" <?php if($layout_type=="slider")echo "selected"; ?> >Slider</option>
                        <option value="list" <?php if($layout_type=="list")echo "selected"; ?> >List</option>                                             
                    </select>
                </div> 
            
            
				<div class="option-box">
                    <p class="option-title">Item width</p>
                    <p class="option-info"></p>
                    <input type="text" name="related_post_settings[grid_item_width]" placeholder="220px or 30%" value="<?php echo $grid_item_width; ?>" />
                </div>             
            
				<div class="option-box">
                    <p class="option-title">Item margin</p>
                    <p class="option-info"></p>
                    <input type="text" name="related_post_settings[grid_item_margin]" placeholder="10px" value="<?php echo $grid_item_margin; ?>" />
                </div>    
                
				<div class="option-box">
                    <p class="option-title">Item padding</p>
                    <p class="option-info"></p>
                    <input type="text" name="related_post_settings[grid_item_padding]" placeholder="10px" value="<?php echo $grid_item_padding; ?>" />
                </div>                          
            
            
				<div class="option-box">
                    <p class="option-title">Item align</p>
                    <p class="option-info"></p>
                    <select name="related_post_settings[grid_item_align]" >
                    	<option value="left" <?php if($grid_item_align=="left")echo "selected"; ?> >Left</option>
                    	<option value="center" <?php if($grid_item_align=="center")echo "selected"; ?> >Center</option>                        
                    	<option value="right" <?php if($grid_item_align=="right")echo "selected"; ?> >Right</option>
                                                                      
                    </select>
                </div>             
            
            
            
            
				<div class="option-box">
                    <p class="option-title">Layout</p>
                    <p class="option-info"></p>
                    
					<?php
                    
					
					
					
                    $class_related_post_functions = new class_related_post_functions();
                    
                    
                    
					
					if(empty($layout_items)){
						
						$layout_items_list = $class_related_post_functions->layout_items();
						//var_dump($layout_items);
						}
					else{
						//$layout_items_main = $class_related_post_functions->layout_items();
						
						$layout_items_list = $layout_items;
						//var_dump($layout_items);
						}	
					
					
					
					
                    ?>
                    
                    
                    <div class="layouts expandable ">
                    
                    <?php
                    
                    foreach($layout_items_list as $key=>$item){
                        
						$name = $item['name'];
						$options = $item['options'];
						
						
						
                        ?>
                        <div class="items">
                        	
                        
                        	<input type="hidden" name="related_post_settings[layout_items][<?php echo $key; ?>][name]" value="<?php echo $name; ?>" />
                        	<?php
                            echo '';
							?>
                        
                        
                            <div class="header">
							<span class="move"><i class="fa fa-bars"></i></span>
                            <span class="expand-collapse"><i class="fa fa-expand"></i><i class="fa fa-compress"></i></span>
							<?php echo $name; 
                            
                                if(!empty($options['hide'])){
                                    
                                    $checked = 'checked';
                                    }
                                else{
                                    $checked = '';
                                    }
                            
                            ?>
                            
                            <label>
                            <input type="checkbox" <?php echo $checked; ?> name="related_post_settings[layout_items][<?php echo $key; ?>][options][hide]" value="yes" />Hide
                            </label>
                            
                            </div>
                            
                            <div class="options">
                            <?php
                            if($key=='title'):
							
							?>
                                <p class="option-info">Title font size</p>
                                <input placeholder="13px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][font_size]" value="<?php if(!empty($title_font_size)) echo $title_font_size; ?>" />
                                
                                <p class="option-info">Title font color</p>
                                <input class="title_font_color related-post-color" placeholder="#ffffff" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][font_color]" value="<?php if(!empty($title_font_color)) echo $title_font_color; ?>" />
                                
                                <p class="option-info">Title line height</p>
                                <input class="title_line_height" placeholder="20px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][line_height]" value="<?php if(!empty($title_line_height)) echo $title_line_height; ?>" />                                
                                
                                
                                
                                <p class="option-info">Linked to post</p>
                                <select name="related_post_settings[layout_items][<?php echo $key; ?>][options][title_linked]">
                                    <option value="yes" <?php if($title_linked == "yes")echo "selected"; ?> >Yes</option>
                                    <option value="no" <?php if($title_linked == "no")echo "selected"; ?> >No</option>                                  
                                </select>
 
 
                                <p class="option-info">Title margin</p>
                                <input class="title_line_height" placeholder="20px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][margin]" value="<?php if(!empty($title_margin)) echo $title_margin; ?>" /> 
                                
                                
                                <p class="option-info">Title padding</p>
                                <input class="title_line_height" placeholder="20px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][padding]" value="<?php if(!empty($title_padding)) echo $title_padding; ?>" />                                 
 
 
                                <p class="option-info">Title icon, font awesome icons</p>
                                <input class="title_line_height" placeholder="fa-circle" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][icon]" value="<?php if(!empty($title_icon)) echo $title_icon; ?>" />  
 
                                <p class="option-info">Title icon font size</p>
                                <input class="title_line_height" placeholder="13px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][icon_font_size]" value="<?php if(!empty($title_icon_font_size)) echo $title_icon_font_size; ?>" />   
 
 
 
 
 
 
 
                            <?php
							
							
							elseif($key=='thumbnail'):
							
								$get_intermediate_image_sizes =  get_intermediate_image_sizes();
								//global $_wp_additional_image_sizes;
								//var_dump($_wp_additional_image_sizes);
								
								$get_intermediate_image_sizes = array_merge($get_intermediate_image_sizes,array('full'));
							
							
							?>
                            
                                <p class="option-info"><?php _e('Thumbnail Size.','team'); ?></p>
                                <select name="related_post_settings[layout_items][<?php echo $key; ?>][options][thumb_size]" >
                                
								<?php

                                foreach($get_intermediate_image_sizes as $size_key){
                                    
                                    ?>
                                    <option value="<?php echo $size_key; ?>" <?php if($thumb_size == $size_key)echo "selected"; ?>>
                                    <?php 
                                    
                                    $size_key = str_replace('_', ' ',$size_key);
                                    $size_key = str_replace('-', ' ',$size_key);						
                                    $size_key = ucfirst($size_key);
            
                                    echo $size_key; 
                                    
                                    ?>
                                    
                                    </option>
                                    <?php
                                    }
                                	?>
  
                                </select>
    
                                        
                                <p class="option-info">Default thumbnail image</p>
                                <input class="related_post_default_img" id="related_post_default_img" placeholder="image url" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][default_img]" value="<?php if(!empty($thumb_default_img)) echo $thumb_default_img; else ''; ?>" /><br />
                                
                                <input id="related_post_404_img_upload" class="related_post_404_img_upload button" type="button" value="Upload Image" />
                                <p class="option-title">Preview</p>
                                <div style="width:250px; height:auto; overflow:hidden;">
                                    
                                    <?php
                                        if(empty($related_post_default_img))
                                            {
                                            ?>
                                            <img class="related_post_default_img_display" width="100%" src="<?php echo related_post_plugin_url.'assets/admin/images/no-thumb.png'; ?>" />
                                            <?php
                                            }
                                        else
                                            {
                                            ?>
                                            <img class="related_post_default_img_display" width="100%" src="<?php echo $related_post_default_img; ?>" />
                                            <?php
                                            }
                                    ?>
                                    
                                    
                                </div>
                                
                                
                                <script>
                                    jQuery(document).ready(function($){
            
                                        var custom_uploader; 
                                     
                                        jQuery('#related_post_404_img_upload').click(function(e) {
                                                                
                                            e.preventDefault();
                                     
                                            //If the uploader object has already been created, reopen the dialog
                                            if (custom_uploader) {
                                                custom_uploader.open();
                                                return;
                                            }
                                    
                                            //Extend the wp.media object
                                            custom_uploader = wp.media.frames.file_frame = wp.media({
                                                title: 'Choose Image',
                                                button: {
                                                    text: 'Choose Image'
                                                },
                                                multiple: false
                                            });
                                    
                                            //When a file is selected, grab the URL and set it as the text field's value
                                            custom_uploader.on('select', function() {
                                                attachment = custom_uploader.state().get('selection').first().toJSON();
                                                jQuery('#related_post_default_img').val(attachment.url);
                                                jQuery('.related_post_default_img_display').attr('src',attachment.url);									
                                            });
                                     
                                            //Open the uploader dialog
                                            custom_uploader.open();
                                     
                                        });
                                        
                                        
                                    })
                                </script>


                                <p class="option-info">Linked to post</p>
                                <select name="related_post_settings[layout_items][<?php echo $key; ?>][options][thumb_linked]">
                                    <option value="yes" <?php if($thumb_linked == "yes")echo "selected"; ?> >Yes</option>
                                    <option value="no" <?php if($thumb_linked == "no")echo "selected"; ?> >No</option>                                  
                                </select>

                                <p class="option-info">Max height</p>
                                <input class="related_post_thumb_max_height" placeholder="180px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][max_height]" value="<?php if(!empty($thumb_max_height)) echo $thumb_max_height; ?>" />


                                <p class="option-info">thumbnail margin</p>
                                <input class="title_line_height" placeholder="20px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][margin]" value="<?php if(!empty($thumbnail_margin)) echo $thumbnail_margin; ?>" /> 
                                
                                
                                <p class="option-info">thumbnail padding</p>
                                <input class="title_line_height" placeholder="20px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][padding]" value="<?php if(!empty($thumbnail_padding)) echo $thumbnail_padding; ?>" /> 




                            <?php
							
				
							
							
							
							
							
							
							elseif($key=='excerpt'):
							
								?>
                                
                                <p class="option-info">Excrpt font size</p>
                                <input placeholder="13px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][font_size]" value="<?php if(!empty($excerpt_font_size)) echo $excerpt_font_size; ?>" />
                                
                                <p class="option-info">Excrpt font color</p>
                                <input class="related_post_excerpt_font_color related-post-color" placeholder="#ffffff" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][font_color]" value="<?php if(!empty($excerpt_font_color)) echo $excerpt_font_color; ?>" />
                                
                                <p class="option-info">Excrpt line height</p>
                                <input class="related_post_excerpt_line_height" placeholder="20px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][line_height]" value="<?php if(!empty($excerpt_line_height)) echo $excerpt_line_height; ?>" />                                

                                <p class="option-info">Excrpt word count</p>
                                <input class="related_post_excerpt_word_count" placeholder="20" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][word_count]" value="<?php if(!empty($excerpt_word_count)) echo $excerpt_word_count; ?>" />                                
                                
                                <p class="option-info">Excrpt read more</p>
                                <input class="related_post_excerpt_read_more" placeholder="Read more" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][read_more_text]" value="<?php if(!empty($excerpt_read_more_text)) echo $excerpt_read_more_text; ?>" />                                 
                                
                                
                                <p class="option-info">thumbnail margin</p>
                                <input class="title_line_height" placeholder="20px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][margin]" value="<?php if(!empty($excerpt_margin)) echo $excerpt_margin; ?>" /> 
                                
                                
                                <p class="option-info">thumbnail padding</p>
                                <input class="title_line_height" placeholder="20px" type="text" name="related_post_settings[layout_items][<?php echo $key; ?>][options][padding]" value="<?php if(!empty($excerpt_padding)) echo $excerpt_padding; ?>" />            
                                
                                
                                
								<?php
							
							
							
							endif;
                            
                            ?>

                            </div>
        
                        </div>
                        <?php
                        
                        }
                    
                    ?>
                    
                    
                    </div>
                    
			 <script>
             jQuery(document).ready(function($)
                {
                    $(function() {
                        $( ".expandable" ).sortable({ handle: '.move' });
                        //$( ".items" ).disableSelection();
                        });
                    
                    })
            
            </script> 
                    
                </div>
            
              

            

            
            
      
            
            
            
            
            
            
            </li>   
            <li style="display: none;" class="box3 tab-box"> 
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Column Number', 'related-post');?></p>
                    
                    <p class="option-info"><?php _e('In Desktop: (min:1000px and max)', 'related-post');?></p>
					<input type="text" placeholder="4"   name="related_post_settings[slider][column_desktop]" value="<?php echo $slider_column_number_desktop;  ?>" />
					
                    <p class="option-info"><?php _e('In Tablet & Small Desktop: (900px max width)', 'related-post');?></p>
                    <input type="text" placeholder="2"  name="related_post_settings[slider][column_tablet]" value="<?php echo $slider_column_number_tablet;  ?>" />  
                   
                    <p class="option-info"><?php _e('In Mobile: (479px max width)', 'related-post');?></p>
                    <input type="text" placeholder="1"  name="related_post_settings[slider][column_mobile]" value="<?php echo $slider_column_number_mobile;  ?>" />
                    
                  
                               
                </div> 
            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Settings', 'related-post');?></p>
                    <p class="option-info"><?php _e('Slider Auto Play', 'related-post');?></p>
                    
                    
                        <select name="related_post_settings[slider][auto_play]">
                            <option value="true" <?php if(($slider_auto_play=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_auto_play=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>
                        
                        
                        
                    <p class="option-info"><?php _e('Slider rewind', 'related-post');?></p>
                        <select name="related_post_settings[slider][rewind]">
                            <option value="true" <?php if(($slider_rewind=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_rewind=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>                        
                        
                    <p class="option-info"><?php _e('Slider loop', 'related-post');?></p>
                        <select name="related_post_settings[slider][loop]">
                            <option value="true" <?php if(($slider_loop=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_loop=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>  
                        
                    <p class="option-info"><?php _e('Slider center', 'related-post');?></p>
                        <select name="related_post_settings[slider][center]">
                            <option value="true" <?php if(($slider_center=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_center=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>                         
                                               
                        
                        
                        
                        
                    <p class="option-info"><?php _e('Slider Stop on Hover', 'related-post');?></p>
                    
                        <select name="related_post_settings[slider][stop_on_hover]">
                            <option value="true" <?php if(($slider_stop_on_hover=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_stop_on_hover=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>    
                        
                        
                    <p class="option-info"><?php _e('Slider Navigation at Top', 'related-post');?></p>
                    
                        <select name="related_post_settings[slider][navigation]">
                            <option value="true" <?php if(($slider_navigation=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_navigation=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>

                        
                        <p class="option-info"><?php _e('Slider Navigation Position', 'related-post');?></p>
                        <select name="related_post_settings[slider][navigation_position]">
                            <option value="topright" <?php if(($slider_navigation_position=="topright")) echo "selected"; ?> ><?php _e('Top Right', 'related-post');?></option>
                            <option value="middle" <?php if(($slider_navigation_position=="middle")) echo "selected"; ?> ><?php _e('Middle', 'related-post');?></option>
                            <option value="middle-fixed" <?php if(($slider_navigation_position=="middle-fixed")) echo "selected"; ?> ><?php _e('Middle fixed', 'related-post');?></option>
                        
                        </select>
                        
                        
                    <p class="option-info"><?php _e('Slider Pagination at Bottom', 'related-post');?></p>
                    
                        <select name="related_post_settings[slider][pagination]">
                            <option value="true" <?php if(($slider_pagination=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_pagination=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>
 
                        
                        
                       <p class="option-info"><?php _e('Pagination Background Color', 'related-post');?></p>
                        <input type="text" name="related_post_settings[slider][pagination_bg]" class="related-post-color" id="" value="<?php echo $slider_pagination_bg; ?>" />
                        
                        <p class="option-info"><?php _e('Pagination Text Color', 'related-post');?></p>
                        <input type="text" name="related_post_settings[slider][pagination_text_color]" class="related-post-color" id="slider_pagination_text_color" value="<?php echo $slider_pagination_text_color; ?>" /> 
                        
                        <p class="option-info"><?php _e('Pagination Number Counting', 'related-post');?></p>
                        <select name="related_post_settings[slider][pagination_count]">
                        	<option value="false" <?php if(($slider_pagination_count=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                            <option value="true" <?php if(($slider_pagination_count=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            
                        </select>
                        
                    <p class="option-info"><?php _e('Slide Speed', 'related-post');?></p>
					<input type="text" placeholder="1000" id="slide_speed" name="related_post_settings[slider][slide_speed]" value="<?php echo $slider_slide_speed; ?>"  />    

                    <p class="option-info"><?php _e('Pagination Slide Speed', 'related-post');?></p>
					<input type="text" placeholder="1000" id="pagination_slide_speed" name="related_post_settings[slider][pagination_speed]" value="<?php echo $slider_pagination_speed; ?>"  />


                    <p class="option-info"><?php _e('Slider Touch Drag Enabled', 'related-post');?></p>
                    
                    
                        <select name="related_post_settings[slider][touch_drag]">
                            <option value="true" <?php if(($slider_touch_drag=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_touch_drag=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>


                    <p class="option-info"><?php _e('Slider Mouse Drag Enabled', 'related-post');?></p>
                    
                        <select name="related_post_settings[slider][mouse_drag]">
                            <option value="true" <?php if(($slider_mouse_drag=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            <option value="false" <?php if(($slider_mouse_drag=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                        </select>


                    <p class="option-info"><?php _e('RTL Enabled', 'related-post');?></p>
                    
                        <select name="related_post_settings[slider][rtl]">
                        <option value="false" <?php if(($slider_rtl=="false")) echo "selected"; ?> ><?php _e('False', 'related-post');?></option>
                            <option value="true" <?php if(($slider_rtl=="true")) echo "selected"; ?> ><?php _e('True', 'related-post');?></option>
                            
                        </select>
                        
                        
                         
                        
                        
                        
                        

                </div>    
            
            
            
            
            
            
            
            </li>  
            <li style="display: none;" class="box4 tab-box">
				
				<div class="option-box">
                    <p class="option-title">Short-code for php file</p>
                    <p class="option-info">Short-code inside loop by dynamic post id you can use anywhere inside loop on .php files.</p>
                    
                    <pre>&#60;?php<br />echo do_shortcode( '&#91;related_post&#93;' ); <br />?&#62;</pre>
                    

                </div>
				
				<div class="option-box">
                    <p class="option-title">Short-code for content</p>
                    <p class="option-info">Short-code inside content for fixed post id you can use anywhere inside content.</p>		
                    <pre>[related_post]</pre>
                   

                </div>
                
            </li>
            <li style="display: none;" class="box5 tab-box"> 
				<div class="option-box">
                    <p class="option-title">Enable stats.</p>
                    <p class="option-info">Enable trace click on related post.</p>
                    <select name="related_post_settings[enable_stats]" >
                    	<option value="enable" <?php if($enable_stats=="enable")echo "selected"; ?> >Enable</option>
                        <option value="disable" <?php if($enable_stats=="disable")echo "selected"; ?> >Disable</option>
                    
                    </select>
                </div> 
                
                
                
				<div class="option-box">
                    <p class="option-title">Top 10 visited post today .</p>
                    <p class="option-info"></p>
					<ul>
					<?php
					
					global $wpdb;
					$table = $wpdb->prefix . "related_post_stats";	
					$to_id = 'to_id';
										
					//$entries = $wpdb->get_results( "SELECT * FROM $table ORDER BY id DESC LIMIT 0, 10" );
					$entries = $wpdb->get_results("SELECT * FROM $table GROUP BY $to_id ORDER BY COUNT($to_id) DESC LIMIT 10", ARRAY_A);
					$count_to_id = $wpdb->get_results("SELECT to_id, COUNT(*) AS to_id FROM $table GROUP BY to_id ORDER BY COUNT(to_id) DESC LIMIT 10", ARRAY_A);
					//echo '<pre>'.var_export($entries, true).'</pre>';
						
					$i = 0;
					if(!empty($entries)):
					
						foreach($entries as $entry){
							
							$to_id = $entry['to_id'];
							$title = get_the_title($to_id);
							
							
							?>
							<li>
							<span><?php echo $count_to_id[$i]['to_id']; ?></span> <a href="#"><?php echo $title; ?></a>
							</li>
							<?php
							$i++;
							}
					
					else:
					
					?>
					<li>
					No stats yet.
					</li>
					<?php
					
					
					endif;

						
							
                    ?>
					
					</ul>



                </div>                 
                
                
                
                
                
                
                
                
                
            </li>
            
        </ul>
    
    
		
    </div>






<p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
                </p>
		</form>


</div> <!-- end wrap -->
