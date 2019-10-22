<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );
?>



<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="bg-grisClaro section inc inc-pos mt-9">	
			<div class="row">

				<div class="col-md-12">
				<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>
					

				</div><!--col end -->

			</div><!-- row end -->

		</div><!-- container end -->

	</div><!-- wrapper end -->
</div>
</div><!-- #page we need this extra closing tag here -->
<a id="sol-presup" class="btn btn-tatu btn-primary" href="<?php echo get_permalink(apply_filters( 'wpml_object_id', 2101, 'post', TRUE, $lang )); ?>" ><?php _e('Request a quote','theme-textdomain');?></a>


<?php wp_footer(); ?>

</body>

</html>

