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
        $admin = new KeyValueModel();
        $admin->setKey(UserTypeEnum::Admin);
        $admin->setValue("Admin");
        //$admin->setValue(UserTypeEnum::toString(UserTypeEnum::Admin));

        $place_admin = new KeyValueModel();
        $place_admin->setKey(UserTypeEnum::PlaceAdmin);
        $place_admin->setValue("Place Admin");

        $place_employee = new KeyValueModel();
        $place_employee->setKey(UserTypeEnum::PlaceEmployee);
        $place_employee->setValue("Place Employee");

        $guest = new KeyValueModel();
        $guest->setKey(UserTypeEnum::Guest);
        $guest->setValue("Guest");

        return collect([$admin, $place_admin, $place_employee, $guest]);
    }
}
