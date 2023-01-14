<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Support\Facades\Hash;

class GroupService {


    public function store(array $data): Group
    {
        $user = Group::create($data);

        return $user;

    }


    public function findGroup(int $id)
    {
        $user = Group::Where('id',$id)->first();

        return $user;
    }
}
