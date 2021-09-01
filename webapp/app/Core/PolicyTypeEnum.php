<?php


namespace App\Core;


class PolicyTypeEnum extends BaseEnum
{
    const Undefined = 0;

    const General = 1;
    const Reservation = 2;
    const Cancellation = 3;
}
