<?php


namespace App\Helpers;


use App\AppModels\KeyValueModel;
use App\Core\UserTypeEnum;
use Illuminate\Support\Collection;

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

    static function userTypes(bool $is_admin = true): Collection
    {
        if ($is_admin) {
            $undefined = new KeyValueModel();
            $undefined->setKey(UserTypeEnum::Undefined);
            $undefined->setValue("Undefined");

            $admin = new KeyValueModel();
            $admin->setKey(UserTypeEnum::Admin);
            $admin->setValue("Admin");

            $place_admin = new KeyValueModel();
            $place_admin->setKey(UserTypeEnum::PlaceAdmin);
            $place_admin->setValue("Place Admin");

            return collect([$undefined, $admin, $place_admin]);
        } else {
            $valet_parking = new KeyValueModel();
            $valet_parking->setKey(UserTypeEnum::ValetParking);
            $valet_parking->setValue("Valet Parking");

            $waiter = new KeyValueModel();
            $waiter->setKey(UserTypeEnum::Waiter);
            $waiter->setValue("Waiter");

            $employee = new KeyValueModel();
            $employee->setKey(UserTypeEnum::DJ);
            $employee->setValue("DJ");

            return collect([$valet_parking, $waiter, $employee]);
        }
    }

    static function userTypesAll(): Collection
    {
        $all_types = new Collection();

        foreach (AppHelper::userTypes() as $user_type)
            $all_types->push($user_type);

        foreach (AppHelper::userTypes(false) as $user_type)
            $all_types->push($user_type);

        return $all_types;
    }

    static function truncateString($str, int $max): string
    {
        if (strlen($str) <= $max)
            return $str;

        $new_string = substr($str, 0, $max);

        if (substr($new_string, -1, 1) != ' ')
            $new_string = substr($new_string, 0, strrpos($new_string, " "));

        return $new_string;
    }
}
