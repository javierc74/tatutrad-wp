<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tatutrad
 */

get_header(); ?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<div class="container">

		
		<div class="row">
			<div class="col-md-12"><p class="blog-titulo"><a href="/blog">Blog</a></p></div>
			</div>
			
			<div class="row">
			    <div class="col-sm-8">
		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );
		



			the_post_navigation();

		

		endwhile; // End of the loop.
		?>
</div>
	<div class="col-sm-4">	
<?php
get_sidebar();
?>
</div>
</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
