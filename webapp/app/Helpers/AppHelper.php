<?php


namespace App\Helpers;


class AppHelper
{
    static function getCode($id, $type, $length = 6): string
    {
        return AppHelper::get2Code($type) . '_' . str_pad($id, $length, '0', STR_PAD_LEFT);
    }

    static function get2Code($number): string
    {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
    }
}
