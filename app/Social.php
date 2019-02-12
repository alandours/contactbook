<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'social';

    public $timestamps = false;

    public function network(){

        return $this->belongsTo(Network::class, 'id_network');
        
    }

}
