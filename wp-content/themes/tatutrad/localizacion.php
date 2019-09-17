<?php
/**
 * Template Name: Localizacion y contacto
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

    <!-- /container -->
    <script type="text/javascript">

var map;
function initMap() {

tatutrad = { lat:37.4011774, lng:-5.9252595 }
  map = new google.maps.Map(document.getElementById('map'), {
    center: tatutrad,
    zoom: 15
  });

  var marker = new google.maps.Marker({map: map, position: tatutrad});
}

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2SZYC54zj247ka3ZZ10jnEmArhljpdVA&callback=initMap">
    </script>   
<?php
get_footer();
?>
