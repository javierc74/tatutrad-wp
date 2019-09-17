<?php

/*
Plugin Name: Memsource Translation Plugin for WordPress
Plugin URI: http://wiki.memsource.com/wiki/WMPL_Plugin
Description: Localize WordPress websites with the help of professional translation tools: translation memories, terminology bases and quality checkers.
Version: 2.7
Text Domain: memsource
Domain Path: /locale
Author: Memsource
Author URI: https://www.memsource.com
License: GPL v2
*/

use Memsource\Registry\AppRegistry;
use Memsource\Utils\SystemUtils;

define('MEMSOURCE_PLUGIN_PATH', dirname(__FILE__));
define('MEMSOURCE_PLUGIN_VERSION', '2.7');
define('MEMSOURCE_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));

require_once(ABSPATH . 'wp-config.php');
require_once(ABSPATH . 'wp-includes/wp-db.php');
require_once(ABSPATH . 'wp-admin/includes/plugin.php' );
require_once(ABSPATH . 'wp-admin/includes/post.php' );
require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');
$wpmlApiFile = ABSPATH . '/wp-content/plugins/sitepress-multilingual-cms/inc/wpml-api.php';
if(file_exists($wpmlApiFile)){
    require_once $wpmlApiFile;
}

global $appRegistry;

require_once dirname(__FILE__) . '/registry/AppRegistry.php';
$appRegistry = new AppRegistry();

add_action('plugins_loaded', 'memsource_plugin_upgrade', 1);
add_action('admin_enqueue_scripts', 'memsource_enqueue_resources');
add_action('admin_menu', 'memsource_plugin_setup_menu');
register_activation_hook(__FILE__, 'memsource_init');
add_action('wp_ajax_generate_token', 'memsource_generate_token');
add_action('admin_action_save_connector_options', 'memsource_save_connector_options');
add_action('admin_action_set_debug_mode', 'memsource_set_debug_mode');
add_action('admin_action_set_api_prefix', 'memsource_set_api_prefix');
add_action('wp_ajax_zip_and_email_log', 'memsource_zip_and_email_log');
add_action('wp_ajax_delete_log', 'memsource_delete_log');
add_action('admin_action_revoke_oauth', 'memsource_revoke_oauth');
add_action('rest_api_init', 'memsource_rest_routes');
add_action('delete_post', 'memsource_delete_post');
add_action('delete_post_meta', 'memsource_delete_post_meta');
add_action('wpml_translation_update', 'memsource_translation_language_change');
add_action('admin_post_memsource_language_mapping_form', array($appRegistry->getLanguageMappingPage(), 'formSubmit'));
add_action('admin_post_memsource_content_settings_form', array($appRegistry->getContentPage(), 'formSubmit'));
add_action('registered_post_type', 'memsource_registered_post_type');
add_action('registered_taxonomy', 'memsource_registered_taxonomy');

add_filter('plugin_action_links', 'memsource_plugin_action_links', 10, 2);

function memsource_plugin_upgrade() {
    global $appRegistry;
    $last_version = $appRegistry->getOptions()->getVersion();
    if (!$last_version) {
        $last_version = '1.0';
    }
    $appRegistry->initSchema();
    $appRegistry->getUpdate()->updateDatabase($last_version);
    $appRegistry->getOptions()->updateVersion();
    // load short codes
    $appRegistry->initShortCodes();
}

function memsource_plugin_setup_menu() {
    global $appRegistry;
    $appRegistry->initPages();
}

function memsource_enqueue_resources() {
    global $pagenow;
    wp_register_script('memsource_js', plugins_url('js/memsource.js', __FILE__), array(), MEMSOURCE_PLUGIN_VERSION, false);
    wp_register_script('clipboard_js', plugins_url('js/clipboard.min.js', __FILE__), array(), MEMSOURCE_PLUGIN_VERSION, false);
    wp_register_style('memsource_css', plugins_url('css/memsource.css', __FILE__), false, MEMSOURCE_PLUGIN_VERSION, 'all');
    wp_enqueue_script('memsource_js');
    wp_enqueue_script('clipboard_js');
    wp_enqueue_style('memsource_css');
}

function memsource_init() {
    global $appRegistry;
    $appRegistry->initOptions();
    if (!memsource_is_wpml_active()){
        wp_die( __( 'Plugin requires WPML multilingual CMS plugin. Download and install the plugin. 
        Visit <a href="https://wpml.org/" target="_blank">https://wpml.org/</a>.', 'memsource-connector' ) );
    }
    $phpVersion = phpversion();
    if (version_compare($phpVersion, '5.6', '>=') !== true){
        wp_die( __( sprintf('Plugin requires PHP 5.6 or higher. Your version is %s. Please, update the version.', $phpVersion), 'memsource-connector' ) );
    }
}

function memsource_is_wpml_active() {
    return is_plugin_active('sitepress-multilingual-cms/sitepress.php');
}

function memsource_rest_routes() {
    global $appRegistry;
    $appRegistry->initRestRoutes();
}

function memsource_plugin_action_links($links, $file) {
    if ($file == basename(dirname(__FILE__)) . '/memsource.php') {
        $links[] = '<a href="' . menu_page_url('memsource-connector', false) . '">' . __('Configure', 'memsource') . '</a>';
    }
    return $links;
}

function memsource_generate_token() {
    global $appRegistry;
    $appRegistry->getOptions()->generateAndSaveToken();
    $appRegistry->getOptions()->updateAdminUser(get_current_user_id());
    header('Content-Type: application/json');
    echo json_encode(['token' => $appRegistry->getOptions()->getToken()]);
    wp_die();
}

function memsource_save_connector_options() {
    global $appRegistry;
    $list_statuses = array();
    if (isset($_POST['list-status-publish'])) {
        $list_statuses[] = "publish";
    }
    if (isset($_POST['list-status-draft'])) {
        $list_statuses[] = "draft";
    }
    $appRegistry->getOptions()->updateListStatuses($list_statuses);
    $appRegistry->getOptions()->updateInsertStatus($_POST['insert-status']);
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit();
}

function memsource_set_debug_mode() {
    global $appRegistry;
    $appRegistry->getOptions()->setDebugMode(isset($_POST['debugMode']));
    if (isset($_POST['debugMode']) && $_POST['debugMode'] == 'on') {
        SystemUtils::logSystemInfo();
    }
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit();
}

function memsource_set_api_prefix() {
    global $appRegistry;
    if (isset($_POST['apiPrefix'])) {
        $appRegistry->getOptions()->updateMemsourceApiPrefix($_POST['apiPrefix']);
    }
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit();
}

function memsource_zip_and_email_log() {
    SystemUtils::logSystemInfo();
    header('Content-Type: application/json');
    $zip_file = SystemUtils::zipAndEmailLogFile();
    echo json_encode(['zipFile' => $zip_file, 'email' => SystemUtils::LOG_EMAIL_RECIPIENT]);
    wp_die();
}

function memsource_delete_log() {
    header('Content-Type: application/json');
    $result = SystemUtils::deleteLogFile();
    echo json_encode($result);
    wp_die();
}

function memsource_revoke_oauth() {
    global $appRegistry;
    $appRegistry->getOptions()->updateOAuthToken(null);
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit();
}

function memsource_delete_post($id){
    global $appRegistry;
    $database = $appRegistry->getDatabase();
    return $database->deleteTranslationsBySetId($id);
}

function memsource_delete_post_meta($id){
    global $appRegistry;
    $database = $appRegistry->getDatabase();
    return $database->deleteTranslationByTargetIdAndType($id[0], \Memsource\Service\TranslationService::CUSTOMFIELD_META_TYPE);
}

function memsource_translation_language_change($args){
    global $appRegistry, $sitepress;
    $database = $appRegistry->getDatabase();

    //change language on custom labels
    $elementTypes = ['post_post', 'post_page'];
    if (isset($args['element_type']) && in_array($args['element_type'], $elementTypes, true)){
        $language = (array)$sitepress->get_element_language_details($args['element_id'], $args['element_type']);
        if (isset($language['language_code'])){
            $type = \Memsource\Service\TranslationService::CUSTOMFIELD_META_TYPE;
            $database->updateTargetLanguageBySetIdAndType($language['language_code'], $args['element_id'], $type);
        }
    }

    return true;
}

function memsource_registered_post_type($type){
    global $appRegistry;

    $params = ['_builtin' => false]; //only custom types
    $postTypes = get_post_types($params, 'objects');
    $customType = isset($postTypes[$type]) ? $postTypes[$type] : null;
    if ($customType !== null){
        $customPost = $appRegistry->createCustomPostService($customType);
        $appRegistry->addContentServiceToContentController($customPost, false);
    }
}

function memsource_registered_taxonomy($type){
    global $appRegistry;

    $params = ['_builtin' => false]; //only custom types
    $taxonomies = get_taxonomies($params, 'objects');
    $taxonomy = isset($taxonomies[$type]) ? $taxonomies[$type] : null;
    if ($taxonomy !== null){
        $customTaxonomy = $appRegistry->createCustomTaxonomyService($taxonomy);
        $appRegistry->addContentServiceToContentController($customTaxonomy, false);
    }
}

if(!memsource_is_wpml_active()){
    deactivate_plugins(['memsource/memsource.php']);
}
