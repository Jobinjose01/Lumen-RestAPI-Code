<?php

namespace App\Validators;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;

class ExpenseValidation{


    public function getRules()
    {
        return [
            'payer_id' => 'required|exists:users,id',           
            'group_id' => 'required|exists:groups,id',           
            'description' => 'required|max:250',           
            'amount' => 'required|numeric|gt:0',           
        ];
      
    }

}

