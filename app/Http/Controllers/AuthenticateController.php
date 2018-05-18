<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//use Tymon\src\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

//
use DateTime;
use App\Http\Controllers\Controller;
//use JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;
//use Tymon\JWTAuth\JWTAuth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\Employee;
use App\EmployeeManager;

class AuthenticateController extends Controller
{
    
    private $employee;
    private $jwtauth;
    
    public function __construct(Employee $employee, JWTAuth $jwtauth)
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the login method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => [
           'showLoginForm',
           'login',
           'showRegistrationForm',
           'register'
           ]]);
       
       $this->$employee= $employee;
       $this->jwtauth = $jwtauth;
   }

    
    public function showRegistrationForm()
    {
        
        
        return json_encode("show registration form ");
    }
  
    public function register(Request $request)
            
    {

        // create the validation rules ------------------------
        $rules = array(                    
            'name'            => 'required',     
            'email'            => 'required|email|unique:employees',     
            'password'         => 'required|min:6',
            'passwordConfirmation' => 'required|same:password',
            'positionID' => 'required',
            'managerID' => 'required_if:positionID,2',
            
        );

        // do the validation ----------------------------------
        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);


        // check if the validator failed -----------------------
        if ($validator->fails()) {

            // get the error messages from the validator

            $errors = $validator->errors();

            $errorsJSON =$errors->toJson();

            return $errorsJSON;

        } else {
            // validation successful ---------------------------

            //save to db
            $password=Hash::make($request->input('password'));



            $newEmployee['password'] = $password;
            $newEmployee['email'] = $request->email;
            $newEmployee['name'] = $request->name;
            $newEmployee['position_id'] = $request->positionID;
            
            Employee::create($newEmployee);
            
            if($request->positionID ==2){ //sales man
                
                //create EmployeeManager instance
                $employeeID = Employee::orderby('created_at', 'desc')->first();
                $employeeManager['employee_id']=$employeeID->id;
                $employeeManager['manager_id']=$request->managerID;
                
                EmployeeManager::create($employeeManager);

                
            }
            
            return $this->login($request);

        }

    }
 
    
    public function showLoginForm()
    {
        
        return json_encode("show login form ");
    }


    public function login(Request $request)
    {
        
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
        
    }
    
    
   
}



