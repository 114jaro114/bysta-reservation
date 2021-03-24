<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    // protected $fillable = ['event_name', 'username',
    //                        'start_date', 'end_date', 'start_time',
    //                        'end_time', 'nights', 'adults', 'childs2to12',
    //                        'childsto2', 'priceForNight', 'overallPriceForNight'];
    protected $fillable = ['event_name','start_date', 'end_date'];
}
