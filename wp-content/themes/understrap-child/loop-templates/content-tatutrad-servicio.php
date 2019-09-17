<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header bg-grisOscuro inc inc-pos mb-7">
        <div class="row">
        <div class="col-sm-10 col-xl-9  offset-sm-1">

        <?php the_title( '<h1 class="entry-title mt-3 mb-4">', '</h1>' ); ?>
        
        <?php
$cf_descripcion = get_post_meta( get_the_ID(), 'descripcion', true );

if ($cf_descripcion){
  echo $cf_descripcion;
}
?>

</div>
</div>
	</header>
<!--
	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
-->
	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
