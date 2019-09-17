<?php

namespace Memsource\Service\Content;

use Memsource\NotFoundException;
use Memsource\Service\DatabaseService;
use Memsource\Service\FilterService;
use Memsource\Service\LanguageService;
use Memsource\Service\OptionsService;
use Memsource\Service\ShortCodeService;
use Memsource\Service\TranslationService;
use Memsource\Service\WPMLService;
use Memsource\Utils\ArrayUtils;
use Memsource\Utils\DatabaseUtils;
use Memsource\Utils\PostUtils;
use Memsource\Utils\StringUtils;


abstract class AbstractPostService extends AbstractContentService implements IContentService
{


    const STATUS_CREATED = 'Created';
    const STATUS_IN_PROGRESS = 'InProgress';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_CANCELLED = 'Cancelled';

    private $optionsService;
    private $databaseService;
    private $shortCodeService;
    private $filterService;
    private $languageService;

    function __construct(OptionsService &$optionsService,
                         DatabaseService &$databaseService,
                         ShortCodeService &$shortCodeService,
                         FilterService $filterService,
                         LanguageService $languageService,
                         WPMLService $WPMLService)
    {
        parent::__construct($WPMLService);

        $this->optionsService = &$optionsService;
        $this->databaseService = &$databaseService;
        $this->shortCodeService = &$shortCodeService;
        $this->filterService = $filterService;
        $this->languageService = &$languageService;
    }



    /**
     * @param $args array
     * @return array
     */
    public function getItems(array $args)
    {
        // turn off paging to return all posts
        $query_args = array('post_type' => $this->getType(), 'nopaging' => true, 'post_status' => $this->optionsService->getListStatuses());
        $last_id = 0;
        if (isset($_GET['newPosts'])) {
            $last_id = $this->optionsService->getLastProcessedId();
        }
        $posts_query = new \WP_Query();
        $this->filterService->addQueryFilters($posts_query, true);
        $query_result = $posts_query->query($query_args);
        $posts = array();
        foreach ($query_result ?: [] as $post) {
            // get last revision
            $original_post_id = $post->ID;
            $post = $this->getLastRevision($post);
            if ($post->ID > $last_id && ($post->post_content != '' || $this->containsCustomField($post->ID))) {
                $posts[] = $this->getPostJson($post, $original_post_id);
            }
        }
        return $posts;
    }



    /**
     * @param $args array
     * @return array|null
     */
    public function getItem(array $args)
    {
        // get last revision
        $original_post_id = $args['id'];
        $original_post = get_post($original_post_id);
        if (!$original_post || $original_post->post_type !== $args['type']) {
            return null;
        }
        $post = $this->getLastRevision($original_post);
        $result_map = $this->getPostContent($post);

        //custom fields
        $customFields = $this->findCustomFields($original_post->ID);
        $customFieldsHTML = $customFields ? $this->customFieldsToHTML($customFields) : '';

        $json_response = $this->getPostJson($post, $original_post_id, true);
        $json_response['content'] = $result_map['transformedContent'] . $customFieldsHTML;
        $json_response['originalContent'] = $result_map['originalContent'];
        $json_response['transformedSourceId'] = $result_map['transformedSourceId'];
        $json_response['meta'] = get_metadata($original_post->post_type, $original_post_id);
        return $json_response;
    }



    public function saveTranslation(array $args)
    {
        parent::saveTranslation($args);

        ArrayUtils::checkKeyExists($args, ['type', 'id', 'lang', 'title', 'content']);
        $post_status = $this->optionsService->getInsertStatus();
        $post_type = $args['type'];
        $source_post_id = $args['id'];
        $language = $args['lang'];
        $title = $args['title'];
        $content = $args['content'];
        $transformedSourceId = isset($args['transformedSourceId']) ? $args['transformedSourceId'] : null;
        // send this optional parameter from the connector (would be extracted from <title id="transformedSourceId">
        
        $customFields = $this->getCustomFieldsFromString($content);
        $content = $this->cleanStringFromCustomFields($content);
        $data = $this->addOrUpdateTranslation($post_type, $post_status, $source_post_id, $language, $title, $content, $transformedSourceId);
        if ($customFields) {
            $this->saveCustomFields($data['translation_id'], $customFields, $language);
        }
        return $data['id'];
    }



    function memsource_store_last_processed_id()
    {
        // compare with stored ID and save only a higher one
        $stored_last_id = $this->optionsService->getLastProcessedId();
        $new_last_id = $_POST['lastId'];
        // find the last revision ID
        $last_revision = $this->getLastRevision(get_post($new_last_id));
        if ($last_revision) {
            $new_last_id = $last_revision->ID;
        }
        $overwrite = isset($_POST['overwrite']);
        if ($overwrite || $new_last_id > $stored_last_id) {
            $this->optionsService->updateLastProcessedId($new_last_id);
            return array('id' => $new_last_id);
        }
        return array('id' => $stored_last_id);
    }



    public function getPost($original_post_id)
    {
        $original_post = get_post($original_post_id);
        return $this->getLastRevision($original_post);
    }



    public function getLastRevision($post)
    {
        $revisions = wp_get_post_revisions($post->ID);
        if ($revisions) {
            foreach ($revisions as $revision) {
                if ($revision->ID > $post->ID) {
                    $post = $revision;
                }
            }
        }
        return $post;
    }



    public function getPostContent($post)
    {
        // handle visual editor short codes
        return $result_map = $this->shortCodeService->shortCodesToHtml($post->post_content, $post->ID);
    }



    public function addOrUpdateTranslation($post_type, $post_status, $source_post_id, $language, $title, $content, $transformedSourceId = 0)
    {
        global $sitepress;
        // if the $language does not exist in WPML, discard the translation
        if (!$this->languageService->isValidTargetLanguage($language)) {
            throw new NotFoundException(sprintf('Target language \'%s\' not found.', $language));
        }
        //get source content
        $content_type = 'post_' . $post_type; //todo move to method getContentType of wpml service
        $source_post = get_post($source_post_id);
        if (!$source_post) {
            throw new NotFoundException(sprintf('Content with id \'%s\' of type \'%s\' not found.', $source_post_id, $post_type));
        }

        //prepare content
        $transformed_content = $this->shortCodeService->htmlToShortCodes($content, $source_post_id, $transformedSourceId);
        if (PostUtils::containsText($transformed_content)) {
            $content = $transformed_content;
        }
        $post_args = array(
            'post_author' => $this->optionsService->getAdminUser(),
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => $post_status,
            'post_type' => $post_type
        );

        //save
        $trid = wpml_get_content_trid($content_type, $source_post_id);
        $translation = wpml_get_content_translation($content_type, $source_post_id, $language);
        if ($translation == WPML_API_TRANSLATION_NOT_FOUND) {
            $target_post_id = wp_insert_post($post_args);
            $sitepress->set_element_language_details($target_post_id, $content_type, $trid, $language);
        } else {
            $post_args['ID'] = $translation[$language];
            $target_post_id = wp_update_post($post_args);
        }

        //prepare response
        $json = $this->getPostJson($this->getPost($target_post_id), $source_post_id, true);
        $json['translation_id'] = $target_post_id;
        return $json;
    }



    public function getPostJson($post, $original_post_id, $add_content = false)
    {
        $json = array(
            'id' => $original_post_id,
            'revision_id' => $post->ID,
            'date' => $post->post_date,
            'date_gmt' => $post->post_date_gmt,
            'modified' => $post->post_modified_gmt, $post->post_modified,
            'modified_gmt' => $post->post_modified_gmt,
            'password' => $post->post_password,
            'slug' => $post->post_name,
            'status' => $post->post_status,
            'type' => $post->post_type,
            'link' => get_permalink($original_post_id),
            'title' => $post->post_title,
            'size' => StringUtils::size($post->post_content)
        );
        if ($add_content) {
            $json['content'] = $post->post_content;
        }
        return $json;
    }



    public function saveWorkData($work_data)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_WORK_DATA;
        foreach ($work_data as $work) {
            $wpdb->insert($table_name, $work);
        }
    }



    public function updateWorkData($post_id, $work_data)
    {
        $this->deleteWorkData($post_id, $work_data[0]['work_uuid']);
        $this->saveWorkData($work_data);
    }



    public function deleteWorkData($post_id, $work_uuid, $language = null)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_WORK_DATA;
        $where = ["post_id" => $post_id, "work_uuid" => $work_uuid];
        if ($language) {
            $where['target_language'] = $language;
        }
        $wpdb->delete($table_name, $where);
    }



    public function getWorkData($post_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_WORK_DATA;
        $sql = "SELECT * FROM " . $table_name . " WHERE post_id = " . $post_id;
        return $wpdb->get_results($sql, ARRAY_A);
    }



    public function getWorkDataByLanguages($post_id, $languages)
    {
        $works = $this->getWorkData($post_id);
        foreach ($works as $work) {
            foreach ($languages as $language) {
                if ($language == $work['target_language']) {
                    return $work;
                }
            }
        }
        return null;
    }



    public function getWorkDataByUuid($post_id, $work_uuid)
    {
        $works = $this->getWorkData($post_id);
        foreach ($works as $work) {
            if ($work['work_uuid'] == $work_uuid) {
                return $work;
            }
        }
        return null;
    }



    public function getWorkUuid($post_id, $languages)
    {
        $work = $this->getWorkDataByLanguages($post_id, $languages);
        return $work ? $work['work_uuid'] : null;
    }



    public function getPostByWorkUuid($work_uuid)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_WORK_DATA;
        $sql = $wpdb->prepare("SELECT post_id FROM {$table_name} WHERE work_uuid = %s LIMIT 1", $work_uuid);
        $post_id = $wpdb->get_var($sql);
        if (!$post_id) {
            return null;
        }
        $args = ['p' => $post_id, 'post_type' => 'post', 'post_status' => 'publish,draft'];
        $posts_query = new \WP_Query();
        $posts = $posts_query->query($args);
        if (!$posts || sizeof($posts) == 0) {
            $args['post_type'] = 'page';
            $posts = $posts_query->query($args);
        }
        return $posts && sizeof($posts) > 0 ? $posts[0] : null;
    }



    public function saveWorkUnitId($post_id, $work_uuid, $work_unit_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_WORK_DATA;
        $data = ['work_unit_uuid' => $work_unit_id];
        $where = ['post_id' => $post_id, 'work_uuid' => $work_uuid];
        $wpdb->update($table_name, $data, $where);
    }



    public function setLanguagesStatus($post_id, $work_uuid, $languages, $status)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_WORK_DATA;
        $data = ['status' => $status];
        $where = ['post_id' => $post_id, 'work_uuid' => $work_uuid];
        foreach ($languages as $language) {
            $where['target_language'] = $language;
            $wpdb->update($table_name, $data, $where);
        }
    }



    /**
     * @inheritdoc
     */
    public function isFolder()
    {
        return true;
    }



    /**
     * Find custom fields if some exists.
     * @param $postId int post/page id
     * @return array
     */
    public function findCustomFields($postId)
    {
        $response = [];
        $result = $this->databaseService->findCustomFieldsByPostId($postId);
        $fieldSettings = $this->databaseService->findContentSettingsByType(DatabaseService::CUSTOM_FIELD_TYPE);

        foreach ($result ?: [] as $field) {
            $key = $field['meta_key'];
            $hash = StringUtils::stringToHex($key);
            if (!isset($fieldSettings[$hash]) || (isset($fieldSettings[$hash]) && $fieldSettings[$hash]['send'] === '1')) {
                $response[$hash] = [
                    'sourceId' => $field['meta_id'],
                    'key' => $key,
                    'value' => $field['meta_value'],
                ];
            }
        }

        return $response;
    }



    /**
     * Insert or update custom fields.
     * @param $postId int post/page id
     * @param $fields array
     * @param $language string
     * @return bool
     */
    protected function saveCustomFields($postId, array $fields, $language)
    {
        $language = strtolower($language);
        $contentType = TranslationService::CUSTOMFIELD_META_TYPE;

        foreach ($fields as $field) {
            $translation = $this->databaseService->getTranslationByItemIdAndTypeAndTargetLanguageAndSetId($field['sourceId'], $contentType, $language, $postId);
            if ($translation === null) {
                $fieldId = add_post_meta($postId, $field['key'], $field['value']);
                $this->databaseService->saveTranslation($field['sourceId'], $fieldId, $language, $contentType, $postId);
                continue;
            }
            update_meta($translation['target_id'], $field['key'], $field['value']);
        }

        return true;
    }



    /**
     * Convert custom fields to the html string.
     * @param $customFields array
     * @return string
     */
    protected function customFieldsToHTML(array $customFields)
    {
        $html = '';
        foreach ($customFields ?: [] as $field) {
            $html .= $this->customFieldToHTML($field['sourceId'], $field['key'], $field['value']);
        }

        return $html;
    }



    /**
     * Convert custom filed to the html string.
     * @param $sourceId int
     * @param $key string
     * @param $value string
     * @return string
     */
    protected function customFieldToHTML($sourceId, $key, $value)
    {
        return sprintf('<div data-type="custom_field" data-source-id="%d"><div id="key">%s</div><div id="value">%s</div></div>', $sourceId, $key, $value);
    }



    /**
     * Find custom fields in the string.
     * @param $string
     * @return array
     */
    protected function getCustomFieldsFromString($string)
    {
        $pattern = $this->getCustomFieldRegexPattern();
        preg_match_all($pattern, $string, $matches, PREG_SET_ORDER);

        $result = [];
        foreach ($matches ?: [] as $match) {
            $result[] = [
                'sourceId' => $match[1],
                'key' => $match[2],
                'value' => $match[3],
            ];
        }

        return $result;
    }



    /**
     * @param $string string
     * @return string
     */
    protected function cleanStringFromCustomFields($string)
    {
        $pattern = $this->getCustomFieldRegexPattern();
        return preg_replace($pattern, '', $string);
    }



    /**
     * Custom field regex pattern, which can be used for example: find the custom field in a text.
     * @return string
     */
    protected function getCustomFieldRegexPattern()
    {
        return '/<div data-type="custom_field" data-source-id="(\d+)"><div id="key">(|.+?)<\/div><div id="value">(|.+?)<\/div><\/div>/s';
    }



    /**
     * Check that post contains any non-empty meta/custom field.
     * @param $postId int
     * @return bool
     */
    protected function containsCustomField($postId) {
        foreach (get_post_meta($postId) as $metaName => $metaValues) {
            if (isset($metaName[0]) && $metaName[0] !== '_') {
                foreach ($metaValues as $metaValue) {
                    if ($metaValue != '') {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}