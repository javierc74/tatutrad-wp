<?php

if ( ! defined('ABSPATH')) exit; // if direct access 

?>


<div class="wrap">
	<?php echo "<h2>".sprintf(__('%s Help', 'related-post'), related_post_plugin_name )."</h2>";?>
    <br />

	<div class="para-settings related-post-admin">  
        
        
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active"><i class="fa fa-hand-o-right"></i> <?php _e('Help & Support','related-post'); ?></li>
            
        </ul> <!-- tab-nav end --> 
        
		<ul class="box">
        
            <li style="display: block;" class="box1 tab-box active">
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Looking for help', 'related-post'); ?></p>
                    <p class="option-info"></p>
					<p>Feel free to contact with any issue for this plugin, Ask any question via forum <a href="<?php echo related_post_qa_url; ?>"><?php echo related_post_qa_url; ?></a> <strong style="color:#139b50;">(free)</strong>
</p>
               </div>            
            
            
            
            
                <div class="option-box">
                    <p class="option-title"><?php _e('FAQ', 'related-post'); ?></p>
                    <p class="option-info"></p>
                    
                    
                    <div class="faq">
                    <?php
                    $class_related_post_functions = new class_related_post_functions();
                    $faq =  $class_related_post_functions->faq();
                    
                    echo '<ul>';
                    foreach($faq as $faq_data){
                        echo '<li>';
                        $title = $faq_data['title'];
                        $items = $faq_data['items'];				
                        
                        echo '<span class="group-title">'.$title.'</span>';
                        
                            echo '<ul>';
                            foreach($items as $item){
                                
                                    echo '<li class="item">';
                                    echo '<a href="'.$item['answer_url'].'"><i class="fa fa-question-circle-o"></i> '.$item['question'].'</a>';
                                
                                    
                                    echo '</li>';	
        
                            }		
                            echo '</ul>';
                    
                        echo '</li>';
                        }
                        
                        echo '</ul>';
                    ?>
        
                    </div>
        
                </div>
            
            
            
            
            </li>
		</ul>

	</div>

    
         
</div>
