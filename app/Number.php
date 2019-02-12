<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{

    public $timestamps = false;

    public function contact(){

        return $this->belongsTo(Contact::class, 'id_contact');
        
    }

    public function type(){

        return $this->belongsTo(Type::class, 'id_type');
        
    }
    
}
