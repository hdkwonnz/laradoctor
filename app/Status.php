<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['doctor_id', 'app_date', 'app_0800', 'app_0815', 'app_0830', 'app_0845',
                           'app_0900', 'app_0915', 'app_0930', 'app_0945',
                           'app_1300', 'app_1315', 'app_1330', 'app_1345',
                           'app_1400', 'app_1415', 'app_1430', 'app_1445'];

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }                       
}
