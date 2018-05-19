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
                ->get(['employees.name as salesManName',
                    'employees.id as salesManID']);
       
       return response()->json(compact('mySalesMen'));
       
   }
   
   
   public function evaluateSalesManForm($id,JWTAuth $jwtAuth ){
       
       $salesMan = Employee::query()
               ->where('id',$id)
               ->get(['name',
                   'id']);
       
       
       return response()->json(compact('salesMan'));
   }
   
   
   public function evaluateSalesMan(Request $request, JWTAuth $jwtAuth ,$id ){
       
       
       
        $manager = $jwtAuth->toUser($jwtAuth->getToken());
        
       //validation 
        
        // create the validation rules ------------------------
        $rules = array(                    
            'performanceID'=> 'required',
            
        );
        
        
        
        // do the validation ----------------------------------
        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed ----------------------
        if ($validator->fails()) {

            // get the error messages from the validator

            $errors = $validator->errors();

            $errorsJSON =$errors->toJson();

            return $errorsJSON;

        } else {
            
            $employeeManager = EmployeeManager::query()
                ->where('employee_id',$id)
                ->where('manager_id',$manager->id)
                ->get([
                    'id'
                ])->first();
            
//            dd($employeeManager);
            $evaluation = new Evaluation();
            $evaluation->employee_manager_id = $employeeManager->id;
            $evaluation->performance_id = $request->performanceID;
            $evaluation->save();
            
            
            
            return response()->json("evaluation is done ");
       
        }
   }
   
   
   
    
}
