<?php


namespace App\Core;


class AppConstant
{
    public static string $select = "Select..";
    public static string $dash = "-";
    public static string $all = "All";

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

    /**
     * @return string
     */
    public static function getAll(): string
    {
        return self::$all;
    }
}
