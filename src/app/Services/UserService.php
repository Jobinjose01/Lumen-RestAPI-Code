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
}
