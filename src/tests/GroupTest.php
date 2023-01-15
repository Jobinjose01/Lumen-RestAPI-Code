<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Group;

class GroupTest extends TestCase
{



    /**
     * api/groups/id [GET]
     */
    public function testShouldReturnGroup(){
        $this->get("api/groups/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                    [
                        'id',
                        'name',
                        'status',
                        'created_at',
                        'updated_at',
                        'deleted_at'
                    ]
                
            ]    
        );
        
    }

     /**
     * api/groups/id [GET]
     */
    public function testShouldReturnGroupValidationError(){
        $this->get("api/groups/qwe", []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure(
            [
                'status',
                'message',
                'code',
                'data'
            ]
        );
        
    }

   
    /**
     * api/groups/create [POST]
     */
    public function testShouldCreateGroup(){

        $data = ['name' => "My Group-".strtotime(date('Y-m-d h:i:s'))];    
        $this->post("api/groups/create", $data);
        $this->seeStatusCode(201);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ]
            ]    
        );
    }

    /**
     * api/groups/create [POST]
     */
    public function testShouldCreateGroupValidationError(){

        $data = ['name' => "House Rent"];    
        $this->post("api/groups/create", $data);
        $this->seeStatusCode(422);
        $this->seeJsonStructure(
            [
                'status',
                'message',
                'code',
                'data'
            ]
        );
    }

}
