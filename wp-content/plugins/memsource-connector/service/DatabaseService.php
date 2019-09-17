<?php

namespace Memsource\Service;


use Memsource\Utils\ActionUtils;
use Memsource\Utils\DatabaseUtils;
use Memsource\Utils\PostUtils;
use Memsource\Utils\StringUtils;
use WP_Query;

class DatabaseService {

    const CUSTOM_FIELD_TYPE = 'custom_field';
    const PAGE_SIZE = 50;

    private $optionsService;

    function __construct(OptionsService &$optionsService) {
        $this->optionsService = &$optionsService;
    }

    function postTrashed($post_id) {
        // if the post belongs to the source language, trash all translations too
        if (!$this->optionsService->wpmlActive()) {
            $language = $this->getLanguage($post_id);
            $source_language = $this->optionsService->getSourceLanguage();
            if ($language == $source_language) {
                foreach ($this->getTranslationData($post_id) as $translation_data) {
                    if ($translation_data['target_language'] != $source_language) {
                        wp_trash_post($translation_data['item_id']);
                    }
                }
            }
        }
    }

    function postUntrashed($post_id) {
        if (!$this->optionsService->wpmlActive()) {
            $language = $this->getLanguage($post_id);
            $source_language = $this->optionsService->getSourceLanguage();
            if ($language == $source_language) {
                foreach ($this->getTranslationData($post_id) as $translation_data) {
                    if ($translation_data['target_language'] != $source_language) {
                        wp_untrash_post($translation_data['item_id']);
                    }
                }
            }
        }
    }

    function postDeleted($post_id) {
        if (!$this->optionsService->wpmlActive()) {
            $language = $this->getLanguage($post_id);
            $source_language = $this->optionsService->getSourceLanguage();
            if ($language == $source_language) {
                foreach ($this->getTranslationData($post_id) as $translation_data) {
                    if ($translation_data['target_language'] != $source_language) {
                        wp_delete_post($translation_data['item_id']);
                    }
                }
                $this->deleteTranslationData($post_id, true);
            }
        }
    }

    function postSaved($post_id) {
        // handle only new posts
        // or set a new language and source post to an existing one
        $post_status = get_post_status($post_id);
        if (!ActionUtils::isAction('heartbeat', 'post') &&
            in_array($post_status, ['publish', 'draft'])
        ) {
            $this->updateTranslationData($post_id);
        }
        return true;
    }

    function updateTranslationData($post_id) {
        if (!$this->optionsService->wpmlActive()) {
            // store data to the memsource_translations table
            $target_language = null;
            if (isset($_POST['target-language'])) {
                $target_language = $_POST['target-language'];
            }
            $translation_group_id = ActionUtils::getParameter('source-post', $post_id);
            if ($translation_group_id == '') {
                $translation_group_id = $post_id;
            }
            if ($target_language && $translation_group_id) {
                return $this->saveTranslationData($post_id, $translation_group_id, $target_language);
            }
        }
        return false;
    }

    function saveTranslationData($post_id, $group_id, $target_language) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        $args = array(
            'item_id' => $post_id,
            'type' => get_post_type($post_id),
            'group_id' => $group_id,
            'target_language' => $target_language
        );
        // update if a row exists for this $post_id and $target_language
        if ($wpdb->replace($table_name, $args) === false) {
            return false;
        }
        return true;
    }

    public function saveTranslation($itemId, $targetId, $targetLanguage, $type, $setId = null) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATION;
        $args = [
            'item_id' => $itemId,
            'target_id' => $targetId,
            'target_language' => $targetLanguage,
            'type' => $type,
            'set_id' => $setId,
        ];
        return $wpdb->replace($table_name, $args) === false;
    }

    function deleteTranslationData($post_id, $all_languages = false) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        if ($all_languages) {
            $post_data = $this->getPostData($post_id);
            $wpdb->delete($table_name, array('group_id' => $post_data['group_id']));
        } else {
            $wpdb->delete($table_name, array('item_id' => $post_id));
        }
    }

    public function deleteTranslationsBySetId($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATION;
        return $wpdb->delete($table_name, array('set_id' => $id));
    }

    public function deleteTranslationByTargetIdAndType($targetId, $type)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATION;
        return $wpdb->delete($table_name, array('target_id' => $targetId, 'type' => $type));
    }

    function getPostData($post_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        $sql = "select *
                  from {$table_name}
                  where item_id = " . $post_id;
        return $wpdb->get_row($sql, ARRAY_A);
    }

    function getTranslationData($post_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        $sql = "select *
                  from {$table_name}
                  where group_id = (select group_id from {$table_name} where item_id = " . $post_id . ")";
        return $wpdb->get_results($sql, ARRAY_A);
    }

    public function getTranslationByItemIdAndTypeAndTargetLanguageAndSetId($itemId, $type, $language, $setId)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATION;
        $query = $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE item_id = %d AND type = %s AND target_language = %s AND set_id = %d', $itemId, $type, $language, $setId);

        return $wpdb->get_row($query, ARRAY_A) ?: null;
    }

    public function updateTargetLanguageBySetIdAndType($language, $setId, $type)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATION;
        $data = ['target_language' => $language];
        $where = ['set_id' => $setId, 'type' => $type];

        return $wpdb->update($table_name, $data, $where);
    }

    function getLanguage($post_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        return $wpdb->get_var("select target_language from {$table_name} where item_id = " . $post_id);
    }

    function getTranslationsForLanguage($language) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        $sql = $wpdb->prepare("select *
                  from {$table_name}
                  where target_language = %s", $language);
        return $wpdb->get_results($sql, ARRAY_A);
    }

    function hasTranslations() {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        return $wpdb->get_var("select count(*) from {$table_name}") > 0;
    }

    function isTranslation($post_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
        $target_language = $wpdb->get_var("select target_language from {$table_name} where item_id = " . $post_id);
        return $target_language != $this->optionsService->getSourceLanguage();
    }

    function createMissingTranslationData() {
        // do it only if there are no records in memsource_translations table
        if (!$this->hasTranslations()) {
            $source_language = $this->optionsService->getSourceLanguage();
            if (!$source_language) {
                $source_language = $this->optionsService->detectSourceLanguage();
            }
            if ($source_language) {
                foreach (PostUtils::$POST_TYPES as $post_type) {
                    $query_args = array('post_type' => $post_type, 'nopaging' => true, 'post_status' => ['publish', 'draft']);
                    $posts_query = new WP_Query();
                    $posts = $posts_query->query($query_args);
                    foreach ($posts as $post) {
                        $this->saveTranslationData($post->ID, $post->ID, $source_language);
                    }
                }
            }
        }
    }

    public function findCustomFieldsByPostId($postId)
    {
        global $wpdb;

        $table = $wpdb->postmeta;
        $query = $wpdb->prepare('SELECT * FROM ' . $table . ' WHERE post_id = %d', $postId);
        $result = $wpdb->get_results($query, ARRAY_A) ?: [];

        foreach ($result as $key => $row){
            if ($this->isSystemCustomField($row) === true){
                unset($result[$key]);
            }
        }

        return $result;
    }

    /**
     * Find unique custom field keys. Without case sensitive.
     * @param int|null $page
     * @return array
    */
    public function findCustomFieldKeys($page = null)
    {
        global $wpdb;

        $limit = '';

        if ($page !== null) {
            $limit = 'LIMIT ' . (self::PAGE_SIZE + 1) . ' OFFSET ' . (($page - 1) * self::PAGE_SIZE);
        }

        $keys = [];
        $table = $wpdb->postmeta;
        $result = $wpdb->get_results(
            "SELECT DISTINCT meta_key FROM $table WHERE meta_key NOT LIKE '\_%' ORDER BY meta_key $limit",
            ARRAY_A
        );

        foreach($result ?: [] as $field){
            $key = $field['meta_key'];
            $hash = StringUtils::stringToHex($key);
            $keys[$hash] = $key;
        }

        return $keys;
    }

    /**
     * Find total count of custom fields.
     * @return int
     */
    public function findCustomFieldsTotalCount()
    {
        global $wpdb;
        $table = $wpdb->postmeta;
        $result = $wpdb->get_results(
            "SELECT COUNT(DISTINCT meta_key) AS total FROM $table WHERE meta_key NOT LIKE '\_%'",
            ARRAY_A
        );

        if (isset($result[0]['total'])) {
            return $result[0]['total'];
        }

        return 0;
    }

    /**
     * @param $code string original language code
     * @param $memsourceCode string memsource language code
     * @return int id of mapping
    */
    public function saveLanguageMapping($code, $memsourceCode)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_LANGUAGE_MAPPING;
        $mapping = $wpdb->get_var($wpdb->prepare('SELECT id FROM ' . $table_name . ' WHERE code = %s', $code));

        //save
        $data = [
            'code' => $code,
            'memsource_code' => $memsourceCode,
        ];
        return $mapping === NULL ? $wpdb->insert($table_name, $data) : $wpdb->update($table_name, $data, ['code' => $code]);
    }

    /**
     * Find all in language mapping table.
     * @return array
    */
    public function findAllLanguageMapping()
    {
        global $wpdb;

        $result = [];
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_LANGUAGE_MAPPING;
        $rows = $wpdb->get_results('SELECT * FROM ' . $table_name, ARRAY_A);
        foreach ($rows ?: [] as $row){
            $result[$row['code']] = $row;
        }
        return $result;
    }

    /**
     * Find language mapping by code.
     * @param $code string original language code
     * @return array|null
    */
    public function findOneLanguageMappingByMemsourceCode($code)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_LANGUAGE_MAPPING;
        $sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE memsource_code = %s', $code);
        return $wpdb->get_row($sql, ARRAY_A) ?: null;
    }

    /**
     * Find all content settings.
     * @param $type string
     * @return array
    */
    public function findContentSettingsByType($type)
    {
        global $wpdb;

        $settings = [];
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_CONTENT_SETTINGS;
        $sql = $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE content_type = %s', $type);
        $result = $wpdb->get_results($sql, ARRAY_A) ?: [];
        foreach ($result as $row){
            $settings[$row['hash']] = $row;
        }

        return $settings;
    }

    /**
     * Save content settings.
     * @param $contentType string
     * @param $contentId string
     * @param $send int
     * @return int|false
    */
    public function saveContentSettings($contentType, $contentId, $send)
    {
        global $wpdb;

        $hash = StringUtils::stringToHex($contentId);
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_CONTENT_SETTINGS;
        $settingsId = $wpdb->get_var($wpdb->prepare('SELECT id FROM ' . $table_name . ' WHERE content_type = %s AND hash = %s ', $contentType, $hash));

        if ($settingsId === null){ //save new content settings
            $params = [
                'hash' => $hash,
                'content_id' => $contentId,
                'content_type' => $contentType,
                'send' => $send,
            ];
            return $wpdb->insert($table_name, $params);
        }
        return $wpdb->update($table_name, ['send' => $send], ['id' => $settingsId]);
    }

    /**
     * Check if is custom field systemic.
     * @param $field array custom filed
     * @return bool
    */
    protected function isSystemCustomField(array $field)
    {
        return substr($field['meta_key'], 0, 1) === '_';
    }
}