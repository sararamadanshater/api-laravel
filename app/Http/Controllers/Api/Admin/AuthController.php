<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Auth;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request){

         try{

            $rules=[
                "email"=>"required|exists:admins,email",
                "password"=>"required"
             ];
     
            $validator=Validator::make($request->all(),$rules);
            if( $validator->fails()){
                 $code=$this->returnCodeAccordingToInput($validator);
                 return $this->returnValidationError($code, $validator);
     
            }

            $credintial=$request->only(['email','password']);
            $token=Auth::guard('admin-api')->attempt($credintial);
            
            if(!$token){
                return $this->returnError("","this login is incorrect");
            }

            // return $this->returnData("token",$token); OR
            $admin=Auth::guard('admin-api')->user();
            $admin->token=$token;
            return $this->returnData("admin",$admin);

        }catch(Exception $e){
            return $this->returnError($e->getCode(),$e->getMessage());


        }
        
    }

    public function logout(Request $request){
        
        $token=$request->header('token');
        if($token){
            try{
                JWTAuth::setToken($token)->invalidate(); //logout
            }
            catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('','something wrong');
                
            }
            
            return $this->returnSuccesMassge("loggout is successfuly");
        }
        else{
            return $this->returnError('','something wrong');
        }

    }
}
