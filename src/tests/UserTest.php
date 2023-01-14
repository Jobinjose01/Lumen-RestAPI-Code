<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTest extends TestCase
{



    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base_endpoint_returns_a_successful_response()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }

    /**
     * api//users/id [GET]
     */
    public function testShouldReturnUser(){
        $this->get("api/users/2", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                    [
                        'id',
                        'name',
                        'username',
                        'status',
                        'api_token',
                        'created_at',
                        'updated_at',
                        'deleted_at'
                    ]
                
            ]    
        );
        
    }
    
    /**
     * api//users/create [POST]
     */
    public function testShouldCreateUser(){

        $user = User::factory()->make();
        $data = array_merge($user->toArray(),['password' => Hash::make('123456')]);    
        $this->post("api/users/create", $data);
        $this->seeStatusCode(201);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'id',
                    'name',
                    'username',
                    'created_at',
                    'updated_at',
                ]
            ]    
        );
    }

    /**
     * api/users/create [POST]
     */
    public function testShouldAssignUser(){

        $this->post("api/usergroups/create",['user_id' => 19, 'group_id' => 2]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'id',
                    'user_id',
                    'group_id',
                    'created_at',
                    'updated_at',
                ]
            ]    
        );
    }

}
