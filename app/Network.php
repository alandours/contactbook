<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{

    public $timestamps = false;

    public function social(){

        return $this->hasMany(Social::class, 'id_network');
        
    }

}
