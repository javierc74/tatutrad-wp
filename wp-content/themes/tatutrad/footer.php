<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tatutrad
 */

?>

	 <!-- /container -->
    <footer>
            <div class="container">

<div class="widget">
<div class="inner"><ul><?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar('subfootercenter') ) : ?>
<?php endif; ?></ul></div>
</div>

         </div>
        </footer>

<?php wp_footer(); ?>

</body>
</html>
