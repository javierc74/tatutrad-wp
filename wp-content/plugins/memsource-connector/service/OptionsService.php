<?php

namespace Memsource\Service;


use Memsource\Registry\LanguageRegistry;
use Memsource\Utils\DatabaseUtils;

class OptionsService {

    const DEFAULT_API_PREFIX = 'https://cloud.memsource.com/web';

    private $REST_NAMESPACE = 'memsource/v1/connector';

    private $OPTION_VERSION = 'memsource_version';
    private $OPTION_DEBUG_MODE = 'memsource_debug_mode';
    private $OPTION_TOKEN = 'memsource_token';
    private $OPTION_ADMIN_USER = 'memsource_admin_user';
    private $OPTION_LAST_PROCESSED_ID = 'memsource_last_processed_id';
    private $OPTION_LIST_STATUS = 'memsource_list_status';
    private $OPTION_INSERT_STATUS = 'memsource_insert_status';
    private $OPTION_TRANSLATE_STATUS = 'memsource_translate_status';
    private $OPTION_AUTOMATION_WIDGET_ID = 'memsource_automation_widget_id';
    private $OPTION_OAUTH_TOKEN = 'memsource_oauth_token';
    private $OPTION_API_PREFIX = 'memsource_api_prefix';
    private $OPTION_SOURCE_LANGUAGE = 'memsource_source_language';
    private $OPTION_TARGET_LANGUAGES = 'memsource_target_languages';

    public function initOptions() {
        add_option($this->OPTION_VERSION, '1.0');
        add_option($this->OPTION_DEBUG_MODE, false);
        add_option($this->OPTION_TOKEN, $this->createNewToken());
        add_option($this->OPTION_ADMIN_USER, get_current_user_id());
        add_option($this->OPTION_LAST_PROCESSED_ID, 0);
        add_option($this->OPTION_LIST_STATUS, 'publish');
        add_option($this->OPTION_INSERT_STATUS, 'publish');
        add_option($this->OPTION_AUTOMATION_WIDGET_ID, null);
        add_option($this->OPTION_OAUTH_TOKEN, null);
        add_option($this->OPTION_API_PREFIX, self::DEFAULT_API_PREFIX);
        add_option($this->OPTION_SOURCE_LANGUAGE, null);
        add_option($this->OPTION_TARGET_LANGUAGES, array());
    }

    public function detectSourceLanguage() {
        $site_locale = get_locale();
        if (!$site_locale) {
            $site_locale = "en_US";
        }
        $source_language = "en";
        if (array_key_exists(strtolower($site_locale), LanguageRegistry::getMap())) {
            $source_language = strtolower($site_locale);
        }
        $this->updateLanguages($source_language, array());
        return $source_language;
    }

    public function wpmlFound() {
        return class_exists('SitePress');
    }

    public function wpmlActive() {
        return $this->wpmlFound();
    }

    public function updateVersion() {
        update_option($this->OPTION_VERSION, MEMSOURCE_PLUGIN_VERSION);
    }

    public function getVersion() {
        return get_option($this->OPTION_VERSION);
    }

    public function setDebugMode($debug_mode) {
        update_option($this->OPTION_DEBUG_MODE, $debug_mode);
    }

    public function isDebugMode() {
        return get_option($this->OPTION_DEBUG_MODE) ?: false;
    }

    public function getRestNamespace() {
        return $this->REST_NAMESPACE;
    }

    public function updateListStatuses(array $list_statuses) {
        update_option($this->OPTION_LIST_STATUS, implode("|", $list_statuses));
    }

    public function updateInsertStatus($insert_status) {
        update_option($this->OPTION_INSERT_STATUS, $insert_status);
    }

    public function getListStatuses() {
        $status = get_option($this->OPTION_LIST_STATUS);
        if (!$status) {
            $status = "publish";
        }
        return explode("|", $status);
    }

    public function getInsertStatus() {
        $status = get_option($this->OPTION_INSERT_STATUS);
        if (!$status) {
            $status = "publish";
        }
        return $status;
    }

    public function updateTranslateStatus($translate_status) {
        update_option($this->OPTION_TRANSLATE_STATUS, $translate_status);
    }

    public function getTranslateStatus() {
        $status = get_option($this->OPTION_TRANSLATE_STATUS);
        if (!$status) {
            $status = "publish";
        }
        return $status;
    }

    public function updateAutomationWidgetId($urlId) {
        return update_option($this->OPTION_AUTOMATION_WIDGET_ID, $urlId);
    }

    public function getAutomationWidgetId() {
        return get_option($this->OPTION_AUTOMATION_WIDGET_ID);
    }

    public function updateLastProcessedId($id) {
        return update_option($this->OPTION_LAST_PROCESSED_ID, $id);
    }

    public function getLastProcessedId() {
        return get_option($this->OPTION_LAST_PROCESSED_ID);
    }

    public function updateMemsourceApiPrefix($api_prefix) {
        return update_option($this->OPTION_API_PREFIX, $api_prefix);
    }

    public function getMemsourceApiPrefix() {
        $api_prefix = get_option($this->OPTION_API_PREFIX);
        return $api_prefix ? $api_prefix : self::DEFAULT_API_PREFIX;
    }

    public function updateOAuthToken($token) {
        return update_option($this->OPTION_OAUTH_TOKEN, $token);
    }

    public function getOAuthToken() {
        return get_option($this->OPTION_OAUTH_TOKEN);
    }

    public function updateLanguages($source_language, $target_languages, $remap_posts = false) {
        // if source language changed, remap posts
        $old_source_language = $this->getSourceLanguage();
        if ($remap_posts && $old_source_language && $old_source_language != $source_language) {
            global $wpdb;
            $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
            if ($wpdb->update($table_name, ['target_language' => $source_language], ['target_language' => $old_source_language]) === false) {
                error_log('Error updating language of translations.');
            }
        }
        update_option($this->OPTION_SOURCE_LANGUAGE, $source_language);
        update_option($this->OPTION_TARGET_LANGUAGES, $target_languages);
    }

    public function getSourceLanguage() {
        return wpml_get_default_language();
    }

    /**
     * @deprecated
    */
    public function getTargetLanguages() {
        throw new \Exception('Use %s class for get active languages.', WPMLService::class);
    }

    public function getAdminUser() {
        return get_option($this->OPTION_ADMIN_USER);
    }

    public function updateAdminUser($user_id) {
        update_option($this->OPTION_ADMIN_USER, $user_id);
    }

    public function generateAndSaveToken() {
        update_option($this->OPTION_TOKEN, $this->createNewToken());
    }

    public function getToken() {
        return get_option($this->OPTION_TOKEN);
    }

    public function getAllMemsourceOptions() {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_OPTIONS;
        $sql = "select *
                  from {$table_name}
                  where option_name like 'memsource%'";
        return $wpdb->get_results($sql, ARRAY_A);
    }

    public function createNewToken() {
        $max_length = 16;
        $token = md5(uniqid());
        if (strlen($token) > $max_length) {
            $token = substr($token, $max_length);
        }
        return $token;
    }

}
