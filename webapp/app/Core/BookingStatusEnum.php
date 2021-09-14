<?php


namespace App\Core;


class BookingStatusEnum extends BaseEnum
{
    const Temp = 0;
    const Approved = 1;
    const Confirmed = 2;
    const Canceled = 3;
}
