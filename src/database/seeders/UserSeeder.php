<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $users = ['John', 'Jane', 'Ronald','Sam','Susie'];

       

        foreach ($users as $name) {
            $data[] = ['name' => $name,'username' => strtolower($name),'password' => Hash::make('123456'), 'status' => '1', 'created_at' => date('Y-m-d h:i:s')];
        }

        $result = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'status' => '1',
        ]);

        
        \DB::table('users')
            ->insert($data);

       
    }
}
