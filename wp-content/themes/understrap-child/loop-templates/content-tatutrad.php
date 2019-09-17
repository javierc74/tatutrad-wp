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
	<?php if ( has_post_thumbnail()) : ?>
		<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
		<header class="entry-header bg-verde mb-2" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat;">
		<?php  else: ?>
		<header class="entry-header bg-verde mb-2">
	<?php endif; ?>

              



	
        <div class="row">
        <div class="col-sm-10 col-xl-9  offset-sm-1">

        <?php the_title( '<h1 class="entry-title mt-6">', '</h1>' ); ?>
        
        <?php
$cf_descripcion = get_post_meta( get_the_ID(), 'descripcion', true );

if ($cf_descripcion){
  echo $cf_descripcion;
}
?>

</div>
</div>
	</header>

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
