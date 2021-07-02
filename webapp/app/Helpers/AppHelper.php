<?php


namespace App\Helpers;


class AppHelper
{
    static function getCode($id, $length = 8): string
    {
        return str_pad($id, $length, '0', STR_PAD_LEFT);
    }
}
