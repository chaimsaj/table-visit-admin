<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BookingHelper
{
    public static function load(Model $item, ?Model $place, Collection $place_types): Model
    {
        $item->is_past = ($item->closed_at != null || $item->canceled_at != null);

        if (isset($place)) {
            $item->place = PlaceHelper::load($place, $place_types);
        }

        $amount_to_pay_default = 0.00;

        $amount_to_pay = round(floatval($item->spent_total_amount) - floatval($item->total_amount), 2);

        $item->amount_to_pay = strval($amount_to_pay > 0.00 && $item->spent_total_amount != $item->paid_amount ? $amount_to_pay : $amount_to_pay_default);

        $item->paid = ($item->amount_to_pay == 0.00 || $item->spent_total_amount == $item->paid_amount);

        return $item;
    }
}
