<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeManager extends Model
{
    use SoftDeletes;
    
    
    protected $fillable = ['employee_id','manager_id'];
    
    protected $table = 'employees_managers';
    
    public function salesMan(){
        
        return $this->belongsTo('App\Employee', 'employee_id');
    }
    public function manager(){
        
        return $this->belongsTo('App\Employee', 'manager_id');
    }
    
    public function evaluations(){
        
        return $this->hasMany('App\Evaluation');
    }
}
