<?php

namespace Memsource\Utils;


final class ArrayUtils
{


    private function __construct()
    {
    }



    /**
     * Check if keys exists and have a value.
     * @param $data array source
     * @param $keys array keys
     * @return array source
     * @throws \InvalidArgumentException
     */
    public static function checkKeyExists(array $data, array $keys)
    {
        foreach ($keys as $key) {
            if (!isset($data[$key]) || $data[$key] === '') {
                throw new \InvalidArgumentException(sprintf('Missing %s.', $key));
            }
        }
        return $data;
    }
}