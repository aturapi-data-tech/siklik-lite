<?php

namespace App\Http\Traits;


trait rmSpecialCharTrait
{
    public static function rmSpecialChar($str)
    {
        $SpecialChar = [
            "+", "-", "&&", "||", "!", "(", ")", "{", "}", "[", "]", "^",
            "~", "*", "?", ":",
        ];

        //Remove "#","'" and ";" using str_replace() function

        $result = str_replace($SpecialChar, '', $str);

        //The output after remove

        return $result;
    }
}
