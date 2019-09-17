<?php

namespace Memsource\Utils;


class PostUtils {

    public static $POST_TYPES = ['post', 'page'];  // PHP < 5.6 fix (does not allow arrays as const)

    public static function containsText($string) {
        return $string != "" &&  !ctype_space(preg_replace("/(&nbsp;)/", "", $string));
    }

    public static function buildFileContent($post_title, $result_map) {
        $post_content = $result_map['transformedContent'];
        $transformed_source_id = $result_map['transformedSourceId'];
        $file_content = '<title';
        if ($transformed_source_id) {
            $file_content .= ' id="' . $transformed_source_id . '"';
        }
        $file_content .= '>' . $post_title . '</title>' . $post_content;
        return $file_content;
    }

}