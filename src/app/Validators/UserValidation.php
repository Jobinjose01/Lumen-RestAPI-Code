<?php

namespace App\Validators;

use App\Models\User;

class UserValidation{


    public function getRules()
    {
        return [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6'
           
        ];
    }

    public function isUser(){
        return [
            'user_id' => 'required|integer|exists:users,id',           
        ];
    }

    public function getAuthendicate(){
        return [
            'username' => 'required|exists:users,username',
            'password' => 'required|min:6'
           
        ];
    }

}

