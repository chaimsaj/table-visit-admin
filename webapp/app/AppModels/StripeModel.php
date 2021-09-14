<?php


namespace App\AppModels;

use App\Core\ApiCodeEnum;
use Illuminate\Support\Collection;

class StripeModel
{
    public string $paymentIntent;
    public string $ephemeralKey;
    public string $customer;
}
