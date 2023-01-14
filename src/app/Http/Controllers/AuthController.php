<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    

        /**
         * authendicate accept request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  $username string
         * @param  $password string
         * @return Json with token or failed status
         */
        public function authendicate(Request $request){

            $username = $request->input('username');
            $password = $request->input('password');
             
            $user = User::where('username', $request->input('username'))->Where('status',1)->first();

            if(!empty($user)){
                if(Hash::check($password, $user->password)){

                    $api_key = bin2hex(random_bytes(32));
                    
                    User::where('username', $request->input('username'))->update(['api_token' => $api_key]);
                   

                    $token_data = ['name' => $user->name, 'access_token' => $api_key];

                    $token = base64_encode(json_encode($token_data));

                    return $this->respondWithToken($token);

                }else{
                    return response()->json(['message' => 'Invalid username or password','status' => 0]);
                }
            }else{
                return response()->json(['message' => 'Invalid username or password','status' => 0]);
            }
        }



        /**
         * RespondWithToken success request with token response.
         * @param  $token string
         * @return Json with token 
         */
        protected function respondWithToken($token){   
       
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => 60 * 60 *60,
                'status' => 1,
                'message' => "login successfull"
            ]);
        }
}
