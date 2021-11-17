<?php


namespace App\Core;


class PaymentMethodEnum extends BaseEnum
{
    const Undefined = 0;
    const Cash = 10;
    const CreditCard = 20;
}
