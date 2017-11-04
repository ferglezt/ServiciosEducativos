<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    public $timestamps = false;

    public function rol() {
    	return $this->belongsTo('App\Rol');
    }
}
