<?php


namespace App\Helpers;


use App\AppModels\KeyValueModel;
use App\Core\UserTypeEnum;
use DateTime;
use Exception;
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

            $customer = new KeyValueModel();
            $customer->setKey(UserTypeEnum::Customer);
            $customer->setValue("Customer");

            return collect([$undefined, $admin, $place_admin, $customer]);
        } else {
            $place_admin = new KeyValueModel();
            $place_admin->setKey(UserTypeEnum::PlaceAdmin);
            $place_admin->setValue("Place Admin");

            $valet_parking = new KeyValueModel();
            $valet_parking->setKey(UserTypeEnum::ValetParking);
            $valet_parking->setValue("Valet Parking");

            $waiter = new KeyValueModel();
            $waiter->setKey(UserTypeEnum::Waiter);
            $waiter->setValue("Waiter");

            $dj = new KeyValueModel();
            $dj->setKey(UserTypeEnum::DJ);
            $dj->setValue("DJ");

            return collect([$place_admin, $valet_parking, $waiter, $dj]);
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

    static function userType($user_type_id)
    {
        return AppHelper::userTypesAll()->firstWhere('key', $user_type_id)->getValue();
        /*return AppHelper::userTypesAll()->first(function ($value) use ($user_type_id) {
            if ($value->getKey() == $user_type_id)
                return $value->getValue();
        });*/
    }

    static function truncateString($str, int $max): string
    {
        if (strlen($str) <= $max)
            return $str;

        $new_string = substr($str, 0, $max);

        if (substr($new_string, -1, 1) != ' ')
            $new_string = substr($new_string, 0, strrpos($new_string, " "));

        return $new_string . "..";
    }

    static function toDateString($data, $format): string
    {
        try {
            if (isset($data) && !empty($data)) {
                $date = new DateTime(strval($data));
                return $date->format($format);
            }
        } catch (Exception $e) {
        }

        return '';
    }

    static function toDate($data, $format)
    {
        try {
            return DateTime::createFromFormat($format, strval($data));
        } catch (Exception $e) {
        }

        return null;
    }
}
