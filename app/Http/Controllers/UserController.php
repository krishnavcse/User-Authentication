<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

/**
 * User controller Class to handler User related API's
 */
class UserController extends Controller 
{
    // HTTP response status code for sucess is 200
    public $successStatus = 200;

    /**
     * method to login
     * @return response (JSON theresponse)
     */
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 

            return response()->json(['success' => $success], $this->successStatus); 
        }
        
        return response()->json(['error'=>'Unauthorised'], 401); 
    }

    /**
     * method to register user
     * @param Request $request
     * @return response (JSON response)
     */
    public function register(Request $request) 
    { 

        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:users,email',
            'mobile_number' => 'sometimes|nullable|numeric|digits:10|unique:users,mobile_number',
            'password' => 'required', 
            'password_confirmation' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 412);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus); 
    }

    /**
     * method to get particular user details based on userId
     * @return response (JSON response)
     */
    public function getUserDetails($userId) 
    { 
        $user = User::find($userId);

        if (is_null($user)) {
            return response()->json(['error' => 'invalid user id'], 404);
        }

        return response()->json(['success' => $user], $this->successStatus); 
    } 

    /**
     * method to get logged in user details
     * @return response (JSON response)
     */
    public function details() 
    { 
        $user = Auth::user(); 

        return response()->json(['success' => $user], $this->successStatus); 
    } 
}