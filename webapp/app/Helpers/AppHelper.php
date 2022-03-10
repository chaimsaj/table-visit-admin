<?php


namespace App\Helpers;


use App\AppModels\KeyValueModel;
use App\Core\UserTypeEnum;
use DateTime;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
        $undefined = new KeyValueModel();
        $undefined->setKey(UserTypeEnum::Undefined);
        $undefined->setValue("Undefined");

        $admin = new KeyValueModel();
        $admin->setKey(UserTypeEnum::Admin);
        $admin->setValue("Admin");

        $place_admin = new KeyValueModel();
        $place_admin->setKey(UserTypeEnum::PlaceAdmin);
        $place_admin->setValue("Place Admin");

        //Staff
        $valet_parking = new KeyValueModel();
        $valet_parking->setKey(UserTypeEnum::ValetParking);
        $valet_parking->setValue("Valet Parking");

       $server = new KeyValueModel();
       $server->setKey(UserTypeEnum::Server);
       $server->setValue("Server");

        $dj = new KeyValueModel();
        $dj->setKey(UserTypeEnum::DJ);
        $dj->setValue("DJ");

        $hookah_waitress = new KeyValueModel();
        $hookah_waitress->setKey(UserTypeEnum::HookahWaitress);
        $hookah_waitress->setValue("Hookah Waitress");

        $customer = new KeyValueModel();
        $customer->setKey(UserTypeEnum::Customer);
        $customer->setValue("Customer");

        if (!$is_admin)
            return collect([$place_admin, $valet_parking,$server, $dj, $hookah_waitress, $customer]);
        else
            return collect([$undefined, $admin, $place_admin, $valet_parking,$server, $dj, $hookah_waitress, $customer]);
    }

    static function userTypesAll(): Collection
    {
        $all_types = new Collection();

        foreach (AppHelper::userTypes() as $user_type)
            $all_types->push($user_type);

        return $all_types;
    }

    static function userType($user_type_id)
    {
        return AppHelper::userTypesAll()->firstWhere('key', $user_type_id)->getValue();
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

    static function getBookingCode($booking_id, $place_id): string
    {
        return sprintf("%04d", $place_id) . sprintf("%08d", $booking_id);
    }

    static function getBookingConfirmationCode($id): string
    {
        return strtoupper(Str::random(4)) . sprintf("%08d", $id);
    }

    static function limitString(?string $data, int $limit): ?string
    {
        if (!empty($data) && strlen($data) > $limit)
            return mb_strimwidth($data, 0, $limit, "..");
        return
            $data;
    }
}
