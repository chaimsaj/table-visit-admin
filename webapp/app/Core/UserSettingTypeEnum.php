<?php


namespace App\Core;


class UserSettingTypeEnum extends BaseEnum
{
    const Undefined = 0;

    const MessagesByEmail = 1;
    const MessagesBySms = 2;

    const RemindersByEmail = 3;
    const RemindersBySms = 4;
}
