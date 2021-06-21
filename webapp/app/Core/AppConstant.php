<?php


namespace App\Core;


class AppConstant
{
    public static string $select = "Select..";
    public static string $dash = "-";

    /**
     * @return string
     */
    public static function getSelect(): string
    {
        return self::$select;
    }

    /**
     * @return string
     */
    public static function getDash(): string
    {
        return self::$dash;
    }
}
