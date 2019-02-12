<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    public $timestamps = false;

    public function number(){

        return $this->hasMany(Number::class, 'id_type');
        
    }

    public function email(){

        return $this->hasMany(Email::class, 'id_type');
        
    }

}
