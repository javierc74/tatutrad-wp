<?php

namespace Memsource\Utils;


final class StringUtils
{


    private function __construct()
    {
    }



    /**
     * Count size of string
     * @param $string string
     * @return int
     */
    public static function size($string)
    {
        return function_exists('mb_strlen') ? mb_strlen($string, 'UTF-8') : strlen($string);
    }



    /**
     * Convert string to hex.
     * @param $string mixed
     * @return mixed
     */
    public static function stringToHex($string)
    {
        $hex = '';
        $max = strlen($string);
        for ($i = 0; $i < $max; $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }
}