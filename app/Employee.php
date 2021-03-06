<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'employees';
    protected $fillable = [
        'name', 'email', 'password', 'position_id', 'manager_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //relations 
    
    
    public function position(){
        
        return $this->belongsTo('App\Position');
    }
    
    
    //with itself
    
    public function salesMen(){
        
        return $this->hasMany('App\EmployeeManager','employee_id');
    }
    
    public function managers(){
        
        return $this->hasMany('App\EmployeeManager','manager_id');
    }
    
}
