<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;

use Tymon\JWTAuth\JWTAuth;

use App\Http\Requests;
use Response;


use App\Employee;

class ProfileController extends Controller
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
   
   public function editProfile(JWTAuth $jwtAuth){
       
       
        $employee = $jwtAuth->toUser($jwtAuth->getToken());
        
        $employeeData = Employee::find($employee->id);
       
       return response()->json(compact('employeeData'));
       
   }
   
   
}
