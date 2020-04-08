<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function providers() {
        return $this->hasMany('App\Provider');
    }

    public function patients() {
        return $this->hasMany('App\Patients');
    }

    public function networks() {
        return $this->hasMany('App\PatientNetwork');
    }
}
