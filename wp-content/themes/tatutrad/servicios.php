<?php
/**
 * Template Name: Servicios
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

        <div class="container principal">
        
		
       		<div class="row">
	            <div class="col-md-12"><h1><?php echo get_the_title(); ?></h1></div>
	        </div>
		<?php
      while ( have_posts() ) : the_post();

       the_content();

        

      endwhile; // End of the loop.
      ?>
    <!--
     <div class="row enlaces-servicios">
      <div class="col-md-6 izquierda">
      <a  href="<?php the_field( "url_1" ) ?>" title="<?php the_field( "title_1" ) ?>"><?php the_field( "enlace_1" ) ?><i class="fa fa-angle-down" aria-hidden="true"></i>
</a>
      
      </div>
      <div class="col-md-6 derecha" >
        <a  href="<?php the_field( "url_2" ) ?>" title="<?php the_field( "title_2" ) ?>"><?php the_field( "enlace_2" ) ?><i class="fa fa-angle-right" aria-hidden="true"></i>
</a>
      </div>
    </div>
    -->
	        </div>
	        <div class="pestana">
	          <?php the_field( "servicios" ) ?>
  </div>
        
    	
    </div>

    <!-- /container -->
  
<?php
get_footer();
?>
