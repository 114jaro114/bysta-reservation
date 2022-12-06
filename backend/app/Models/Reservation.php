<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ReservationUserContactInfo;

class Reservation extends Model
{
    protected $guarded = [];
    // protected $fillable = ['event_name', 'username',
    //                        'start_date', 'end_date', 'start_time',
    //                        'end_time', 'nights', 'adults', 'childs2to12',
    //                        'childsto2', 'priceForNight', 'overallPriceForNight'];
    // protected $fillable = ['event_name','start_date', 'end_date'];
    public function usermodel()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email', 'status', 'avatar', 'created_at');
    }

    public function usercontactmodel()
    {
        return $this->hasOne(ReservationUserContactInfo::class);
    }
}
