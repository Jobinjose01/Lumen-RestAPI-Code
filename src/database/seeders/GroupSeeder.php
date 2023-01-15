<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $groups = ['House Rent', 'Tour Club', 'Weekend Party'];

       

        foreach ($groups as $name) {
            $data[] = ['name' => $name, 'status' => '1', 'created_at' => date('Y-m-d h:i:s')];
        }

       
        \DB::table('groups')
            ->insert($data);

       
    }
}
