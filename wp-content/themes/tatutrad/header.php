<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tatutrad
 */
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">

<?php wp_head(); ?>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-53104474-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-53104474-1');
</script>
<script type="text/javascript">
  if (typeof hmtracker == 'undefined') {
    var hmt_script = document.createElement('script');
    hmt_purl = encodeURIComponent(location.href).replace('.', '~');
    hmt_script.type = "text/javascript";
    hmt_script.src = "//samcooper.reviewlocal.es/?hmtrackerjs=Tatutrad&uid=17f2291604949a31380722dd178e53a320375fa4&purl="+hmt_purl;
    document.getElementsByTagName('head')[0].appendChild(hmt_script);
  }
</script>

</head>

<body <?php body_class(); ?> >
<div>
<div class="container">
<nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

      <a href="/" class="navbar-brand">
      <?php	if (is_page_template() || is_front_page()): ?>
      <?php	if (is_front_page()): ?>
      <img width="90" alt="Logotipo de Tatutrad" src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/>
      <?php else: ?>
      <img width="90" alt="Logotipo de Tatutrad" src="<?php echo get_template_directory_uri(); ?>/images/logo-blanco.png"/>
      <?php endif ;?>
<?php else: ?>
<img width="90" alt="Logotipo de Tatutrad" src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/>
			<?php endif ;?>
      
    </a>
		  </div>
		 
          <div id="navbar" class="navbar-collapse collapse">
         
          <?php wp_nav_menu( array(
	'theme_location'  => 'social',
	'depth'	          => 1, // 1 = no dropdowns, 2 = with dropdowns.
	'container_id'    => 'bs-example-navbar-collapse-2',
	'menu_class'      => 'navbar-nav nav',
	'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
	'walker'          => new WP_Bootstrap_Navwalker(),
) );
			?>
		  <?php wp_nav_menu( array(
	'theme_location'  => 'primary',
	'depth'	          => 2, // 1 = no dropdowns, 2 = with dropdowns.
	
	'container_id'    => 'bs-example-navbar-collapse-1',
	'menu_class'      => 'navbar-nav nav',
	'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
	'walker'          => new WP_Bootstrap_Navwalker(),
) );
      ?>
     
      
           
		
          </div><!--/.nav-collapse -->
        
      </nav>
	  </div>
	  </div>
