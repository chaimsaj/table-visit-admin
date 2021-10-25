<?php


namespace App\Core;


class UserTypeEnum extends BaseEnum
{
    const Undefined = 0;

    //Admin
    const Admin = 1;
    const PlaceAdmin = 2;

    //Staff
    const ValetParking = 3;
    const Waiter = 4;
    const DJ = 5;
    const HookahWaitress = 7;

    //Customer
    const Customer = 6;
}
