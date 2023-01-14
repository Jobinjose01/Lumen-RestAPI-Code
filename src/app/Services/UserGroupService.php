<?php

namespace App\Services;

use App\Models\UserGroup;

class UserGroupService {


    public function store(array $data): UserGroup
    {   
        $count = UserGroup::Where('user_id',$data['user_id'])->Where('group_id',$data['group_id'])->count();

        if($count ==  0){
            $user_group = UserGroup::create($data);
        }else{
            $user_group = new UserGroup;
        }

        return $user_group;

    }
   
}
