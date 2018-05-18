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
        'name', 'email', 'password',
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
    
    public function evaluations(){
        
        return $this->hasMany('App\Evaluation');
    }
    
    public function position(){
        
        return $this->belongsTo('App\Position');
    }
    
    
    //with itself
    
    public function employees(){
        
        return $this->hasMany('App\Employee','manager_id');
    }
    
    public function manager(){
        
        return $this->belongsTo('App\Employee','manager_id');
    }
    
}
