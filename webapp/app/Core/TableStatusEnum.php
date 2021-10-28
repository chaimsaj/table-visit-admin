<?php


namespace App\Core;


class TableStatusEnum extends BaseEnum
{
    const Undefined = 0;

    const Available = 1;
    const HoldOn = 5;
    const Reserved = 10;
    const OnUse = 15;
}
