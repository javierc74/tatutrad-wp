<?php

namespace Memsource\Service;


use Memsource\Utils\ActionUtils;
use Memsource\Utils\DatabaseUtils;

class LanguageService {

    private $optionsService;
    private $databaseService;

    function __construct(OptionsService &$optionsService, DatabaseService &$databaseService, WPMLService &$wpmlService) {
        $this->optionsService = &$optionsService;
        $this->databaseService = &$databaseService;
        $this->wpmlService = $wpmlService;
        add_action('wp_ajax_update_translation_data', array($this, 'updateTranslationData'));
    }

    public function updateTranslationData() {
        $post_id = $_POST['postId'];
        $success = $this->databaseService->updateTranslationData($post_id);
        header('Content-Type: application/json');
        echo json_encode(["success" => $success]);
        wp_die();
    }

    public function getActiveLanguages($replaceByMapping = FALSE) {
        $response = array('source' => null, 'target' => array());
        if ($this->optionsService->wpmlFound()) {
            $default_language = apply_filters('wpml_default_language', null);
            $active_languages = $this->wpmlService->getActiveLanguages();
            $mapping = $replaceByMapping === TRUE ? $this->databaseService->findAllLanguageMapping() : [];
            foreach ($active_languages as $language) {
                $originalCode = $language['code']; //because $default_language contains original language code
                $language['code'] = isset($mapping[$language['code']]) ? $mapping[$language['code']]['memsource_code'] : $language['code'];
                if ($originalCode === $default_language) {
                    $response['source'] = $language;
                } else {
                    $response['target'][] = $language;
                }
            }
        } else {
          return array('error' => 'WPML plugin not found.');
        }
        return $response;
    }

    public function getSourceLanguage() {
        $source = $this->getActiveLanguages()['source'];
        return $source && array_key_exists('code', $source) ? $source['code'] : null;
    }

    public function getTargetLanguages() {
        $target = $this->getActiveLanguages()['target'];
        $response = array();
        if (sizeof($target) > 0) {
            foreach ($target as $language) {
                $response[] = $language['code'];
            }
        }
        return $response;
    }

    public function isValidTargetLanguage($language) {
        return in_array($language, $this->getTargetLanguages());
    }

    public function languageSetupFinished() {
        $source_language = $this->optionsService->getSourceLanguage();
        $target_languages = $this->optionsService->getTargetLanguages();
        return $source_language && sizeof($target_languages) > 0;
    }

    public function getAllLanguageCodes() {
        $codes = array();
        $active_languages = $this->getActiveLanguages();
        if ($active_languages['source'] && array_key_exists('code', $active_languages['source'])) {
            $codes[] = $active_languages['source']['code'];
        }
        if (sizeof($active_languages['target']) > 0) {
            foreach ($active_languages['target'] as $language) {
                $codes[] = $language['code'];
            }
        }
        return $codes;
    }

    public function getSelectedLanguageCode() {
        $language = $this->optionsService->getSourceLanguage();
        $lang = ActionUtils::getParameter('lang');
        if ($lang) {
            $language = $lang;
            // sanitize
            if (!preg_match('/^[A-Za-z-_]+$/', $language)) {
                $language = $this->optionsService->getSourceLanguage();
            }
        }
        return $language;
    }

    function getLanguagePostCount($post_type, $post_status, $post_author) {
        global $wpdb;
        $translations_table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        $posts_table_name = $wpdb->prefix . DatabaseUtils::TABLE_POSTS;
        if ($post_status) {
            $sql = $wpdb->prepare("select a.target_language langCode, count(a.id) postCount
                  from {$translations_table_name} a 
                    inner join {$posts_table_name} b
                      on a.item_id = b.ID
                      and b.post_type = %s
                      and b.post_status = %s
                  group by a.target_language", $post_type, $post_status);
        } else {
            if ($post_author) {
                $sql = $wpdb->prepare("select a.target_language langCode, count(a.id) postCount
                  from {$translations_table_name} a 
                    inner join {$posts_table_name} b
                      on a.item_id = b.ID
                      and b.post_type = %s
                      and (b.post_status = 'publish'
                        or b.post_status = 'future'
                        or b.post_status = 'draft'
                        or b.post_status = 'pending'
                        or b.post_status = 'private')
                      and b.post_author = %d
                  group by a.target_language", $post_type, $post_author);
            } else {
                $sql = $wpdb->prepare("select a.target_language langCode, count(a.id) postCount
                  from {$translations_table_name} a 
                    inner join {$posts_table_name} b
                      on a.item_id = b.ID
                      and b.post_type = %s
                      and (b.post_status = 'publish'
                        or b.post_status = 'future'
                        or b.post_status = 'draft'
                        or b.post_status = 'pending'
                        or b.post_status = 'private')
                  group by a.target_language", $post_type);
            }
        }
        return $wpdb->get_results($sql, ARRAY_A);
    }

}