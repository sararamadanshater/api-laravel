<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\GeneralTrait;

class CheckAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      

        $user=null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // return response()->json(['status' => 'Token is Invalid']);
                return $this->returnError("000","Token is Invalid");
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // return response()->json(['status' => 'Token is Expired']);
                return $this->returnError("000","Token is Expired");
            }else{
                // return response()->json(['status' => 'Authorization Token not found']);
                return $this->returnError("000","Authorization Token not found");
            }
        }catch (Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // return response()->json(['status' => 'Token is Invalid']);
                return $this->returnError("000","Token is Invalid");
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // return response()->json(['status' => 'Token is Expired']);
                return $this->returnError("000","Token is Expired");
            }else{
                // return response()->json(['status' => 'Authorization Token not found']);
                return $this->returnError("000","Authorization Token not found");
            }
        }

        if(!$user){
            // return response()->json(['success'=>false,'msg'=>trans('unauthenticated'),200]);
            return $this->returnError("000","unauthenticated");
        }
        return $next($request);
    }
}
