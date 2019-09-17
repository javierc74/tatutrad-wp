<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package tatutrad
 */

get_header(); ?>

<div class="cont-main">
<div class="background slider-home" >
<div class="slide" style="background: url('/wp-content/themes/tatutrad/images/tatutrad3Home.jpg') repeat scroll 50% bottom / cover ;"></div>
	
	<div class="slide" style="background: url('/wp-content/themes/tatutrad/images/tatutrad4Home.jpg') repeat scroll 50% bottom / cover ;"></div>
	<div class="slide" style="background: url('/wp-content/themes/tatutrad/images/tatutrad2Home.jpg') repeat scroll 50% bottom / cover ;"></div>
	<div class="slide" style="background: url('/wp-content/themes/tatutrad/images/tatutrad5Home.jpg') repeat scroll 50% bottom / cover ;"></div>
	
</div>
<div id="main" role="main">
		 

        <div class="container">
        
			
		<div class="row">
	            <div class="col-md-12">
	            	<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'tatutrad' ); ?></h1>
	            	<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'tatutrad' ); ?></p>
	            </div>
	        </div>

		

</div>
    </div>
    </div>

<?php
get_footer();
