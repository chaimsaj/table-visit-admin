<?php


namespace App\Core;


class UserTypeEnum extends BaseEnum
{
    const Undefined = 0;

    const Admin = 1;
    const PlaceAdmin = 2;
    const ValetParking = 3;
    const Waiter = 4;
    const Employee = 5;

    const Customer = 6;
}
