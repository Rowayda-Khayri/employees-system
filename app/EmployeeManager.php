<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeManager extends Model
{
    use SoftDeletes;
    
    public function salesMan(){
        
        return $this->belongsTo('App\Employee');
    }
    public function manager(){
        
        return $this->belongsTo('App\Employee');
    }
    
    public function evaluations(){
        
        return $this->hasMany('App\Evaluation');
    }
}
