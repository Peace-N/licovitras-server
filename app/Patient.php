<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{

    protected $fillable = ['name', 'address', 'latitude', 'longitude', 'cell', 'email'];

    const STATUS_OK = 0;
    CONST STATUS_SICK = 0;

    public function provider() {
        return $this->belongsTo('App\Provider');
    }

    public function region() {
        return $this->belongsTo('App\Region');
    }

    public function networks() {
        return $this->hasMany('App\PatientNetwork');
    }
}
