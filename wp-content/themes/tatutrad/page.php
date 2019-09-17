<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tatutrad
 */

get_header(); ?>

<div class="cont-main">
<div class="background slider-home" >
<div class="slide" style="background: url('http://localhost/wp-content/themes/tatutrad/images/tatutrad3Home.jpg') repeat scroll 50% bottom / cover ;"></div>
	
	<div class="slide" style="background: url('/wp-content/themes/tatutrad/images/tatutrad4Home.jpg') repeat scroll 50% bottom / cover ;"></div>
	<div class="slide" style="background: url('/wp-content/themes/tatutrad/images/tatutrad2Home.jpg') repeat scroll 50% bottom / cover ;"></div>
	<div class="slide" style="background: url('/wp-content/themes/tatutrad/images/tatutrad5Home.jpg') repeat scroll 50% bottom / cover ;"></div>
	
</div>
<div id="main" role="main">
		 

        <div class="container">
        
		

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				
			endwhile; // End of the loop.
			?>

		</div>
    </div>
    </div>

<?php

get_footer();
