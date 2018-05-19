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
use App\EmployeeManager;
use App\Evaluation;

class SalesManController extends Controller
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
   
   
   public function listMyEvaluations(JWTAuth $jwtAuth){
       
       
        $salesMan = $jwtAuth->toUser($jwtAuth->getToken());
        
//        dd($salesMan->id);
        $evaluations = Evaluation::query()
                ->leftjoin('employees_managers as em', 'em.id', '=', 'evaluations.employee_manager_id')
                ->leftjoin('employees as e', 'em.manager_id', '=', 'e.id')
                ->leftjoin('performances as p', 'p.id', '=', 'evaluations.performance_id')
                ->where('em.employee_id',$salesMan->id)
                ->get([
                    'p.name as performance',
                    'e.name as manager'
                ]);
        
        
       return response()->json(compact('evaluations'));
                
       
   }
   
   
   
   
}
