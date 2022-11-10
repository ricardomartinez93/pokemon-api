<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pokemon extends Model
{
    
    protected $fillable = [
        'pokemon_id','user_id'
    ];
    
}
