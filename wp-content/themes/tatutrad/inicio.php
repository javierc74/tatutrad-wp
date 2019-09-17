<?php
/**
 * Template Name: Inicio
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
<div class="cont-main">
<div class="background slider-home" >
<div class="slide uno"></div>
	
	<div class="slide dos"></div>
	<div class="slide tres"></div>
	<div class="slide cuatro"></div>
	
</div>
<div id="main" role="main">
		
        <div class="container">
        
       		
			<div class="row">
	            <div class="col-md-12"><h1><?php the_field( "texto_principal" ) ?></h1></div>
	        </div>
	        
	        <div class="row">
	        	<div class="col-md-4"><div class="barreras"></div><h2><?php the_field( "subtitulo_1" ) ?></h2><p><?php the_field( "texto_1" ) ?></p></div>
	         	<div class="col-md-4"><div class="puntualidad"></div><h2><?php the_field( "subtitulo_2" ) ?></h2><p><?php the_field( "texto_2" ) ?></p></div>
	         	<div class="col-md-4"><div class="calidad"></div><h2><?php the_field( "subtitulo_3" ) ?></h2><p><?php the_field( "texto_3" ) ?></p></div>
	        </div>

	        <div class="row enlaces">
			<div class="col-md-6 izquierda">
			<a  href="<?php the_field( "url_1" ) ?>" title="<?php the_field( "title_1" ) ?>"><?php the_field( "enlace_1" ) ?><i class="fa fa-angle-down" aria-hidden="true"></i>
</a>
			
			</div>
			<div class="col-md-6 derecha" >
				<a  href="<?php the_field( "url_2" ) ?>" title="<?php the_field( "title_2" ) ?>"><?php the_field( "enlace_2" ) ?><i class="fa fa-angle-right" aria-hidden="true"></i>
</a>
			</div>
		</div>
        
    	</div>
    </div>
    </div>
<div id="home-post" >
	<div class="container" >
		<h2>
			<?php esc_html_e( 'Latest posts', 'tatutrad' ); ?>
		</h2>
<?php
// el primer parametro es un array que indica el alto y ancho de la imagen
// el segunº	án los con las miniaturas
// el tercero la clase de las imagenes extraidas

 sugeridos(array(750,360),'articulos_relacionados','miniaturas');
?>
		<div class="text-center enlaces">
			<a href="blog"><?php esc_html_e( 'Blog', 'tatutrad' ); ?><i class="fa fa-angle-right" aria-hidden="true"></i>
</a>
		</div>
	</div>
	</div>
<div id="clientes" >
<?php the_field( "campo_de_texto" ) ?>
	
</div>
    <!-- /container -->
   
<?php
get_footer();
?>
