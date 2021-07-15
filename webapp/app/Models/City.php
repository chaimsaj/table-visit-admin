<?php

namespace App\Models;

use App\Models\Base\AppBaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends AppBaseModel
{
    use HasFactory;

    protected $table = 'cities';
}
