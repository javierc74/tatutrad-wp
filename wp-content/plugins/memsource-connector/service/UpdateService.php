<?php

namespace Memsource\Service;


use Memsource\Utils\DatabaseUtils;
use Memsource\Utils\SystemUtils;

class UpdateService {

    private static $version_history = ['2.0'];

    public function updateDatabase($last_version) {
        global $wpdb;
        foreach (self::$version_history as $version) {
            if (version_compare($last_version, $version, '<')) {
                $file_name = SystemUtils::getUpdateFolder("sql") . "/update-${version}.sql";
                if (file_exists($file_name)) {
                    $handle = fopen($file_name, "r");
                    if ($handle) {
                        while (($line = fgets($handle)) !== false) {
                            $wpdb->query(str_replace("{wp_db_prefix}", $wpdb->prefix, $line));
                        }
                        fclose($handle);
                    }
                }
                $file_name = SystemUtils::getUpdateFolder("json") . "/update-${version}.json";
                if (file_exists($file_name)) {
                    $json_object = json_decode(file_get_contents($file_name));
                    foreach ($json_object->shortCodes as $short_codes) {
                        $code_type = $short_codes->type;
                        foreach ($short_codes->values as $short_code) {
                            $table_name = $wpdb->prefix . DatabaseUtils::TABLE_SHORT_CODES;
                            $sql = $wpdb->prepare("select * from {$table_name} where type = %s and tag = %s", [$code_type, $short_code->tag]);
                            if (!$wpdb->get_row($sql)) {
                                $wpdb->insert($table_name, [
                                    'type' => $code_type,
                                    'tag' => $short_code->tag,
                                    'ignore_body' => array_key_exists('ignoreBody', $short_code) && $short_code->ignoreBody
                                ]);
                                if (isset($short_code->attributes)) {
                                    $short_code_id = $wpdb->insert_id;
                                    $table_name = $wpdb->prefix . DatabaseUtils::TABLE_SHORT_CODE_ATTRIBUTES;
                                    foreach ($short_code->attributes as $attribute) {
                                        $wpdb->insert($table_name, [
                                            'short_code_id' => $short_code_id,
                                            'name' => $attribute->name
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}