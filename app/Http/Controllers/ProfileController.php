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
   
   public function updateProfile(JWTAuth $jwtAuth , Request $request){
       
        $employee = $jwtAuth->toUser($jwtAuth->getToken());
        
        //validation 
        
        // create the validation rules ------------------------
        $rules = array(                    
            'name'            => 'required',
            'email' => 'required|email',
            
            
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
            
            $employeeData = Employee::find($employee->id);
            
            $employeeData->name = $request->name;
            $employeeData->email = $request->email;
            $employeeData->updated_at = new DateTime();
            
            $employeeData->save();
            
            return response()->json("Profile is updated ");
       
        }
        
        
        
        
        
   }
}
