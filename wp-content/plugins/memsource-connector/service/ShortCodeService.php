<?php

namespace Memsource\Service;


use Memsource\Utils\ActionUtils;
use Memsource\Utils\DatabaseUtils;
use Memsource\Utils\PostUtils;
use Memsource\Utils\SystemUtils;

class ShortCodeService {

    const SHORT_CODE_PLAIN_TEXT = "memsource_plain_text";

    private $short_code_cache = [];
    private $short_code_types = [];

    private $optionsService;

    function __construct(OptionsService &$optionsService) {
        $this->optionsService = &$optionsService;
        add_action('admin_action_add_update_short_code', array($this, 'addOrUpdateShortCodeEndpoint'));
        add_action('admin_action_delete_short_code', array($this, 'deleteShortCodeEndpoint'));
    }

    function init() {
        // load short codes to the cache
        $this->loadFromJson('2.0');  // if the UpdateService insert failed, reload from JSON
        $this->loadFromJson('2.4');  // if the UpdateService insert failed, reload from JSON
        $this->loadFromJson('2.4.3');  // if the UpdateService insert failed, reload from JSON
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_SHORT_CODES;
        $sql = "select * from {$table_name} order by type";
        $short_codes = $wpdb->get_results($sql, ARRAY_A);
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_SHORT_CODE_ATTRIBUTES;
        $sql = "select * from {$table_name}";
        $short_code_attributes = $wpdb->get_results($sql, ARRAY_A);
        foreach ($short_codes as $short_code) {
            if (!array_key_exists('delimiter', $short_code)) {
              $short_code['delimiter'] = "\"";
            }
            if (!$this->hasShortCode($short_code['tag'])) {  // avoid duplicities
                $id = $short_code['id'];
                $type = $short_code['type'];
                if (!in_array($type, $this->short_code_types)) {
                    $this->short_code_types[] = $type;
                }
                $attrs = [];
                foreach ($short_code_attributes as $short_code_attribute) {
                    if ($short_code_attribute['short_code_id'] === $id) {
                        $attrs[] = $short_code_attribute;
                    }
                }
                $short_code['attributes'] = $attrs;
                $this->short_code_cache[] = $short_code;
            }
        }
    }

    function loadFromJson($version) {
        $file_name = SystemUtils::getUpdateFolder("json") . "/update-" . $version . ".json";
        if (file_exists($file_name)) {
            $json_object = json_decode(file_get_contents($file_name));
            foreach ($json_object->shortCodes as $short_codes) {
                $code_type = $short_codes->type;
                if (!in_array($code_type, $this->short_code_types)) {
                    $this->short_code_types[] = $code_type;
                }
                $delimiter = array_key_exists('delimiter', $short_codes) ? $short_codes->delimiter : "\"";
                foreach ($short_codes->values as $code) {
                    $short_code = [
                      'type' => $code_type,
                      'tag' => $code->tag,
                      'ignore_body' => array_key_exists('ignoreBody', $code) && $code->ignoreBody,
                      'editable' => false,
                      'status' => 'Active',
                      'delimiter' => $delimiter,
                    ];
                    $attrs = [];
                    if (isset($code->attributes)) {
                        foreach ($code->attributes as $attribute) {
                            $attrs[] = [
                              'name' => $attribute->name,
                              'type' => null,
                              'encoding' => null,
                              'editable' => false,
                              'status' => 'Active',
                            ];
                        }
                    }
                    $short_code['attributes'] = $attrs;
                    $this->short_code_cache[] = $short_code;
                }
            }
        }
    }

    /**
     * Parse attributes and content from short codes.
     *
     * Sample input:
     *   $content = '[tag id="1"]text[/tag]';
     *   $shortCodeName = 'tag';
     * Output:
     *   [' id="1"', 'text']
     *
     * @see ShortCodeServiceTest::testParseShortCode() for more info about usage.
     * @param string $content Post, page or any other content.
     * @param string $shortCodeName Name of shortcode.
     * @return array|bool Returns array of two parsed elements (attributes and body) or false in case of failure.
     */
    function parseShortCode($content, $shortCodeName) {
        $pattern = "#\[${shortCodeName}(\s+[^]]*]|])(.*?)\[/${shortCodeName}]#sm";

        if (!preg_match($pattern, $content, $matches)) {
            return false;
        }

        $wholeShortCode = $matches[0];

        $attributesPattern = '/(\[((?:[^\[\]]++|(?R))*)\])/m'; // Find matching bracket using PCRE recursive pattern

        if (!preg_match($attributesPattern, $wholeShortCode, $matches)) {
            return false;
        }

        $attributes = preg_replace("/^\s*$shortCodeName/", '', $matches[2], 1);

        if (!preg_match($pattern, str_replace($attributes, '', $wholeShortCode), $matches)) {
            return false;
        }

        return [$attributes, $matches[2]];
    }

    function shortCodesToHtml($content, $original_post_id) {
        $original_content = $content;
        $result = "";
        $transformed_source_id = null;
        if (PostUtils::containsText($content)) {
            // ATTENTION! The following plain text section might not be necessary (at least Visual Composer does not have it)
            // so we comment it out for the time being
            // extract possible plain text:
            // add custom short codes, e.g. [memsource_plain_text:unique-id] to mark plain text areas
            // 1) before the first opening short code
            /*            $match_result = preg_match("|^(.+?)\[.+?\]|smU", $content, $matches);
                        if ($match_result == 1) {
                            $extracted_text = $matches[1];
                            $short_code_with_id = self::SHORT_CODE_PLAIN_TEXT . ':' . $this->optionsService->createNewToken();
                            $result = '<div id="' . $short_code_with_id . '">"' . $extracted_text . '</div>';
                        }*/
            // 2) between a closing and opening short codes (multiple matches)
            // 3) after the last closing short code
            // iterate through known short codes
            foreach ($this->short_code_cache as $short_code_object) {
                $short_code = $short_code_object['tag'];
                if (sizeof($short_code_object['attributes']) > 0) {
                    // this is for non-pair tags (text in attributes)
                    $delimiter = $short_code_object['delimiter'];
                    foreach ($short_code_object['attributes'] as $attribute_object) {
                        $match_result = 1;
                        $attribute = $attribute_object['name'];
                        while ($match_result == 1) {
                            $match_result = preg_match("|\[${short_code}[^]]+?${attribute}=${delimiter}([^${delimiter}]+?)${delimiter}.*?\]|sm", $content, $matches);
                            if ($match_result == 1) {
                                $extracted_text = $matches[1];
                                $attribute_with_id = $attribute . ':' . $this->optionsService->createNewToken();
                                $new_content = preg_replace("|(\[${short_code}[^]]+?)${attribute}(=${delimiter}[^${delimiter}]+?${delimiter}.*?\])|sm", "$1${attribute_with_id}$2", $content, 1);
                                if (strlen($new_content) === strlen($content)) {
                                    error_log("Infinite loop detected, aborting: ${content}");
                                    $match_result = 0;
                                } else {
                                    $content = $new_content;
                                }
                                // HTML encode
                                $result .= '<div id="' . $attribute_with_id . '" class="attribute">' . $extracted_text . "<!-- end:attribute delimiter:${delimiter} --></div>";
                            }
                        }
                    }
                }
                if (!isset($short_code_object['ignore_body']) || !$short_code_object['ignore_body']) {
                    // this is for pair tags (text in between)
                    $parsedShortCode = true;
                    while ($parsedShortCode) {
                        $parsedShortCode = $this->parseShortCode($content, $short_code);
                        if ($parsedShortCode) {
                            $attributes = preg_replace("|]$|", "", $parsedShortCode[0]);
                            $extracted_text = $parsedShortCode[1];
                            $short_code_with_id = $short_code . ':' . $this->optionsService->createNewToken();
                            $needle = "[${short_code}${attributes}]";
                            $position = strpos($content, $needle);
                            // this is a fail-safe to avoid infinite loops if the string replacement fails (should never happen but ...)
                            $new_content = substr_replace($content, "[${short_code_with_id}${attributes}]", $position, strlen($needle));
                            if (strlen($new_content) === strlen($content)) {
                                error_log("Infinite loop detected, aborting: ${content}");
                                $parsedShortCode = false;
                            } else {
                                $content = $new_content;
                            }
                            // detect Base64 encoded content in fusion_code tag, decode and mark it in end:tag
                            $base64_detected = FALSE;
                            if ($short_code == 'fusion_code') {
                                $decode_result = base64_decode($extracted_text, TRUE);
                                if ($decode_result !== FALSE) {
                                    $extracted_text = html_entity_decode($decode_result);
                                    $base64_detected = TRUE;
                                }
                            }
                            // HTML encode
                            $result .= '<div id="' . $short_code_with_id . '" class="tag">' . $extracted_text . '<!-- end:tag base64:';
                            $result .= var_export($base64_detected, true);
                            $result .= ' --></div>';
                        }
                    }
                }
            }
            if (PostUtils::containsText($result)) {
                // generate an unique ID
                $transformed_source_id = $this->optionsService->createNewToken();
                // store transformed content to the database table
                $this->storeTransformedContent($transformed_source_id, $original_post_id, $content);
            }
        }
        // return a map with unique ID (will be used in <title> tag) and the result text
        // no short codes found, return original text
        return [
            'originalContent' => $original_content,
            'transformedContent' => PostUtils::containsText($result) ? $result : $content,
            'transformedSourceId' => $transformed_source_id
        ];
    }

    function htmlToShortCodes($content, $original_post_id, $transformed_source_id) {
        // find the text in the database table by $transformedSourceId
        $result = $this->getTransformedContent($transformed_source_id);
        SystemUtils::debug("Stored: ${result}");
        if ($result) {
            $content = stripslashes($content);  // fix escaped quotes
            SystemUtils::debug("Content: ${content}");
            // 1) Pair tags - iterate content for <div id="shortCodeWithId">Translated text</div>
            // find the transformed short code, strip the unique-id and replace its text with the translation
            // check end:tag if the content should be encoded to a Base64 string
            $match_result = preg_match_all("|<div id=\"([^:]+?):([^\"]+?)\" class=\"tag\">(.*?)<!-- end:tag( base64:([^\s]+))? --></div>|sm", $content, $matches, PREG_SET_ORDER);
            if ($match_result > 0) {
                foreach ($matches as $match) {
                    $short_code = $match[1];
                    $unique_id = $match[2];
                    $extracted_text = $match[3];
                    if (sizeof($match) >= 5 && $match[5] == 'true') {
                        $translated_text = base64_encode(htmlentities($extracted_text));
                    } else {
                        $translated_text = html_entity_decode($extracted_text);
                    }
                    $short_code_with_id = $short_code . ":" . $unique_id;
                    $result = preg_replace("|\[${short_code_with_id}([^]]*)\].*?\[/${short_code}\]|sm", "[${short_code}$1]${translated_text}[/${short_code}]", $result);
                }
            }
            // 2) Attributes from non-pair tags - iterate content for <span id="shortCodeWithId">Translated text</span>
            // find the transformed short code, strip the unique-id and replace its text with the translation
            $match_result = preg_match_all("|<div id=\"([^:]+?):([^\"]+?)\" class=\"attribute\">(.+?)<!-- end:attribute( delimiter:([^\s]+))? --></div>|sm", $content, $matches, PREG_SET_ORDER);
            if ($match_result > 0) {
                foreach ($matches as $match) {
                    $attribute = $match[1];
                    $unique_id = $match[2];
                    $delimiter = '"';
                    if (sizeof($match) >= 5) {
                      $delimiter = $match[5];
                    }
                    $translated_text = html_entity_decode($match[3]);
                    $attribute_with_id = $attribute . ":" . $unique_id;
                    $result = preg_replace("| ${attribute_with_id}=[\"'].*?[\"']|sm", " ${attribute}=${delimiter}${translated_text}${delimiter}", $result);
                }
            }
        }
        return $result;
    }

    function storeTransformedContent($transformed_source_id, $original_post_id, $content) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSFORMED_CONTENT;
        $wpdb->insert($table_name, [
            'uuid' => $transformed_source_id,
            'post_id' => $original_post_id,
            'content' => $content
        ]);
    }

    function getTransformedContent($transformed_source_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSFORMED_CONTENT;
        return $wpdb->get_var($wpdb->prepare("select content from {$table_name} where uuid = %s", $transformed_source_id));
    }

    function deleteTransformedContent($transformed_source_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSFORMED_CONTENT;
        $wpdb->delete($table_name, array('uuid' => $transformed_source_id));
    }

    function getShortCodeData() {
        return ["types" => $this->short_code_types, "codes" => $this->short_code_cache];
    }

    function findShortCode($short_code) {
        foreach ($this->short_code_cache as $short_code_object) {
            if (strcasecmp($short_code_object['tag'], $short_code) === 0) {
                return $short_code_object;
            }
        }
        return null;
    }

    function hasShortCode($short_code) {
        foreach ($this->short_code_cache as $short_code_object) {
            if (strcasecmp($short_code_object['tag'], $short_code) === 0) {
                return true;
            }
        }
        return false;
    }

    function addOrUpdateShortCodeEndpoint() {
        $short_code = ActionUtils::getParameter("shortCode", '');
        $attributes = ActionUtils::getParameter("attributes", '');
        if (strlen($short_code) > 0 && !$this->hasShortCode($short_code)) {
            $attribute_list = $attributes ? explode(",", $attributes) : [];
            if ($this->hasShortCode($short_code)) {
                $this->updateShortCode($short_code, $attribute_list);
            } else {
                $this->addShortCode($short_code, $attribute_list);
            }
        }
        wp_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }

    function deleteShortCodeEndpoint() {
        $short_code = ActionUtils::getParameter("shortCode");
        if ($short_code) {
            $this->deleteShortCode($short_code);
        }
        wp_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }

    function addShortCode($short_code, $attribute_list) {
        global $wpdb;
        $table_name = $wpdb->prefix . DatabaseUtils::TABLE_SHORT_CODES;
        $wpdb->insert($table_name, [
            'type' => 'Custom',
            'tag' => $short_code,
            'editable' => true
        ]);
        if (sizeof($attribute_list) > 0) {
            $short_code_id = $wpdb->insert_id;
            $table_name = $wpdb->prefix . DatabaseUtils::TABLE_SHORT_CODE_ATTRIBUTES;
            foreach ($attribute_list as $attribute) {
                $attribute = trim($attribute);
                if (strlen($attribute) > 0) {
                    $wpdb->insert($table_name, [
                        'short_code_id' => $short_code_id,
                        'name' => $attribute,
                        'editable' => true
                    ]);
                }
            }
        }
    }

    function updateShortCode($short_code, $attribute_list) {

    }

    function deleteShortCode($short_code) {
        $short_code_object = $this->findShortCode($short_code);
        if ($short_code_object) {
            global $wpdb;
            $table_name = $wpdb->prefix . DatabaseUtils::TABLE_SHORT_CODE_ATTRIBUTES;
            $wpdb->delete($table_name, array('short_code_id' => $short_code_object['id'], 'editable' => true));
            $table_name = $wpdb->prefix . DatabaseUtils::TABLE_SHORT_CODES;
            $wpdb->delete($table_name, array('id' => $short_code_object['id'], 'editable' => true));
        }
    }

}