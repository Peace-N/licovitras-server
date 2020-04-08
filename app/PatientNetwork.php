<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientNetwork extends Model
{
    public function region() {
        return $this->belongsTo('App\Region');
    }

    public function patient() {
        return $this->belongsTo('App\Patient');
    }
}
