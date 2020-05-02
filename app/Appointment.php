<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes; //for soft delete
    
    protected $dates = ['deleted_at']; //for soft delete

    protected $fillable = ['patient_id','doctor_id','doctor_email','app_date','app_time','status'];

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
