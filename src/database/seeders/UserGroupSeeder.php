<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserGroup;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        $data[] = ['user_id' => 1, 'group_id' => '1'];
        $data[] = ['user_id' => 2, 'group_id' => '1'];
     
        \DB::table('user_groups')->insert($data);

       
    }
}
