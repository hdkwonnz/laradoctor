<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public function patients()
    {
        return $this->hasMany('App\Patient');
    }

    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }

    public function statuses()
    {
        return $this->hasMany('App\Status');
    }
}
