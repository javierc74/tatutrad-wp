<?php
/**
 * Template Name: Como trabajamos
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tatutrad
 */

get_header(); ?>

<div id="main" role="main">
		

        <div class="container">
        
		
       		<div class="row">
	            <div class="col-md-12"><h1><?php echo get_the_title(); ?></h1></div>
	        </div>
		<?php
      while ( have_posts() ) : the_post();

       the_content();

        

      endwhile; // End of the loop.
      ?>
    </div>
    </div>

    <!-- /container -->
   
<?php
get_footer();
?>
