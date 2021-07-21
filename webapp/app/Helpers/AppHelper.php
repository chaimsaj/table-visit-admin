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

    static function userTypes(): Collection
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

        $valet_parking = new KeyValueModel();
        $valet_parking->setKey(UserTypeEnum::ValetParking);
        $valet_parking->setValue("Valet Parking");

        $waiter = new KeyValueModel();
        $waiter->setKey(UserTypeEnum::Waiter);
        $waiter->setValue("Waiter");

        $employee = new KeyValueModel();
        $employee->setKey(UserTypeEnum::Employee);
        $employee->setValue("Employee");

        return collect([$undefined, $admin, $place_admin, $valet_parking, $waiter, $employee]);
    }
}
