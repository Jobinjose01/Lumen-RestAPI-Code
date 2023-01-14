<?php

namespace App\Validators;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;

class UserGroupValidation{


    public function getRules()
    {
        return [
            'user_id' => 'required|exists:users,id',           
            'group_id' => 'required|exists:groups,id',           
        ];
      
    }

}

