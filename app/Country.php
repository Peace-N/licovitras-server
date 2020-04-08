<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function covids() {
        return $this->hasMany('App\Covid');
    }
}
