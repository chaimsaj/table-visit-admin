<?php

namespace App\Models;

use App\Models\Base\AppBaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingGuest extends AppBaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'booking_guests';
}
