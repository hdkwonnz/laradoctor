<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }
}
