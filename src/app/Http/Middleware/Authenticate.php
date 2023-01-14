<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\User;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {  
        $token = $request->bearerToken();
      /*   if (!empty($token)) {

            $user =  User::where('api_token', $token)->first();
            $request->input('user_id',$user->id);            
            $request->input('role_id',2);            
            if (empty($token) || empty($user)) {
                return response('Unauthorized.', 401);
            }
            //TODO: Role of the token can be verified and prevent unauthorized access
            //Even if the user alter roles from Client side
        } */
       
        return $next($request);
    }
}
