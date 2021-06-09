<?php


namespace App\Core;


class UserTypeEnum extends BaseEnum
{
    const Undefined = 0;
    const Admin = 1;
    const PlaceAdmin = 2;
    const PlaceEmployee = 3;
    const Guest = 4;
}
