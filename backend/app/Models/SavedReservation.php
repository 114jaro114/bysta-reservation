<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SavedReservationUserContactInfo;

class SavedReservation extends Model
{
  protected $guarded = [];

  public function usermodel()
  {
      return $this->belongsTo(User::class)->select('id', 'name', 'email', 'status', 'avatar', 'created_at');
  }

  public function usercontactmodel()
  {
      return $this->hasOne(SavedReservationUserContactInfo::class);
  }
}
