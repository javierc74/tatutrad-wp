<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'fontawesome-styles', get_stylesheet_directory_uri() . '/css/fontawesome-all.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'slick-styles', get_stylesheet_directory_uri() . '/css/slick.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'slick-theme-styles', get_stylesheet_directory_uri() . '/css/slick-theme.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'aos-styles', 'https://unpkg.com/aos@next/dist/aos.css', array(), $the_theme->get( 'Version' ) );

    wp_enqueue_script( 'jquery');

    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );

    wp_enqueue_script( 'bootstrap-scripts', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'slick-scripts', get_stylesheet_directory_uri() . '/js/slick.min.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'matchheight-scripts', get_stylesheet_directory_uri() . '/js/jquery.matchHeight-min.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'tatutrad-scripts', get_stylesheet_directory_uri() . '/js/tatutrad.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'aos-scripts', 'https://unpkg.com/aos@next/dist/aos.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );


add_action("wp_enqueue_scripts", "dcms_insertar_google_fonts");

function dcms_insertar_google_fonts(){
    $url = "https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i";
    wp_enqueue_style('google_fonts', $url);
 }


 function my_recent_posts_shortcode($atts){
    $q = new WP_Query(
        array( 'orderby' => 'rand', 'posts_per_page' => '3')
    );
    $list = '<div class="row justify-content-sm-center recent-posts">';
    while($q->have_posts()) : $q->the_post();
        $list .= '<div class="col-sm-3"><a href="'.get_permalink().'"><div class="card"><div>'.get_the_post_thumbnail().'</div><div class="p-2"><div class="date">'.get_the_date().'</div><div class="tatu-title-post">'. get_the_title().'</div></div></div></a></div>';
    endwhile;
    wp_reset_query();
    return $list . '</div>';
    }
    add_shortcode('recent-posts', 'my_recent_posts_shortcode'
);

/**
 * Enqueue block editor style
 */
function legit_block_editor_styles() {
    wp_enqueue_style( 'legit-editor-styles', get_theme_file_uri( '/css/style-editor.css' ), false, '1.0', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'legit_block_editor_styles' );


/**/
  // This theme uses wp_nav_menu() in one location.
  register_nav_menus(array(
    'primary' => esc_html__('Primary', 'tatutrad'),
    'social' => esc_html__('Social', 'tatutrad'),
    'idiomas' => esc_html__('Idiomas', 'tatutrad')
));

add_action( 'after_setup_theme', 'register_nav_menus' );

/* Añadir clase al body */
function my_plugin_body_class($classes) {
    $classes[] = 'no-padd';
    return $classes;
}

add_filter('body_class', 'my_plugin_body_class'); 

if (function_exists('add_theme_support'))
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(750, 360, array(
        'top',
        'left'
    ));

add_image_size( 'single-post-thumbnail', 750, 360 , array( 'top', 'left'));
