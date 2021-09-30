<?php

namespace App\Models;

use App\Models\Base\AppBaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSetting extends AppBaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_settings';
}
