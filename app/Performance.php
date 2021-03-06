<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Performance extends Model
{
    use SoftDeletes;
    
    public function evaluations(){
        
        return $this->hasMany('App\Evaluation');
    }
}
