<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;

use Tymon\JWTAuth\JWTAuth;

use App\Http\Requests;
use Response;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\Employee;


class ManagerController extends Controller
{
    
    private $employee;
    private $jwtauth;
    
    public function __construct(Employee $employee, JWTAuth $jwtauth)
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the login method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => [
          
           ]]);
       
       $this->employee = $employee;
       $this->jwtauth = $jwtauth;
   }
   
   
   public function listMySalesMen(JWTAuth $jwtAuth){
       
       
        $manager = $jwtAuth->toUser($jwtAuth->getToken());
        
//        dd($manager->id);
        $mySalesMen = Employee::query()
                ->leftjoin('employees_managers as em', 'em.employee_id', '=', 'employees.id')
                ->where('em.manager_id',$manager->id)
                ->get(['employees.name as salesManName']);
       
       return response()->json(compact('mySalesMen'));
       
   }
    
}
