<?php

namespace App\Validators;

use App\Models\Group;

class GroupValidation{


    public function getRules()
    {
        return [
            'name' => 'required|max:150|unique:groups',           
        ];
    }

    public function isGroup(){
        return [
            'group_id' => 'required|integer|exists:groups,id',           
        ];
    }

}

