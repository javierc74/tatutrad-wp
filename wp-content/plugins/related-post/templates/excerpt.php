<?php

if ( ! defined('ABSPATH')) exit; // if direct access 
	


//$get_the_excerpt = get_the_excerpt(get_the_ID());
//var_dump($get_the_excerpt);


$post = get_post(get_the_ID());

$post_excerpt = $post->post_excerpt;
$post_content = $post->post_content;

//var_dump($post_excerpt);

if(!empty($post_excerpt)){
	$post_excerpt = strip_tags($post_excerpt);
	}
else{
	$post_excerpt = strip_tags($post_content);
	}

//var_dump($post_excerpt);
//$excerpt = get_the_excerpt(get_the_ID());
$excerpt_text = wp_trim_words( $post_excerpt , $excerpt_word_count, ' <a class="read-more" href="'.get_permalink(get_the_ID()).'"> '.$excerpt_read_more_text.'</a>' );
?>

<div class="excerpt">
<?php 

echo apply_filters('related_post_filter_post_excerpt', $excerpt_text);

?>
</div>