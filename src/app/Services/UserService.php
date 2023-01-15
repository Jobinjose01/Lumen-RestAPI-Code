<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService {




    public function store(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $user;

    }


    public function findUser(int $id)
    {
        $user = User::Where('id',$id)->first();

        return $user;
    }

    public function authendicate(array $data)
    {
        $user = User::where('username', $data['username'])->Where('status',1)->first();

        if(Hash::check($data['password'], $user->password)){

            $api_key = bin2hex(random_bytes(32));
            
            User::where('username', $data['username'])->update(['api_token' => $api_key]);
            

            $token_data = ['name' => $user->name, 'access_token' => $api_key];

            $token = base64_encode(json_encode($token_data));

            $response =  $this->respondWithToken($token);

        }else{
            $response = [];
        }

        return $response;
        
    }

    /**
     * RespondWithToken success request with token response.
     * @param  $token string
     * @return Json with token 
     */
    protected function respondWithToken($token){   
    
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 60 * 60 *60,
            'status' => 1,
            'message' => "login successfull"
        ];
    }
}
