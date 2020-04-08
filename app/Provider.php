<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    public function region() {
        return $this->belongsTo('App\Region');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function patients() {
        return $this->hasMany('App\Patient');
    }
}
