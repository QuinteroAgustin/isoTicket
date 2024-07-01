<?php

namespace App\Helpers;

class Utf8Encoder
{
    public static function encodeDataToUTF8($data)
    {
        if (is_array($data)) {
            return array_map([self::class, 'encodeDataToUTF8'], $data);
        } elseif (is_object($data)) {
            $encodedObject = new \stdClass();
            foreach ($data as $key => $value) {
                $encodedObject->$key = self::encodeDataToUTF8($value);
            }
            return $encodedObject;
        } else {
            return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        }
    }
}
