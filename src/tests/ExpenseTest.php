<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Expense;

class ExpenseTest extends TestCase
{



    /**
     * api/expense/group_id [GET]
     */
    public function testShouldReturnGroupExpense(){
        $this->get("api/expense/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' => ['*' =>
                    [
                        'id',
                        "description",
                        "amount",
                        "payer_id",
                        "group_id",
                        "created_at",
                        "updated_at",
                        "payer_name",
                        "group_name"
                    ]
                ]
                
            ]    
        );
        
    }

     /**
     * api/expense/id [GET]
     */
    public function testShouldReturnGroupExpenseValidationError(){
        $this->get("api/expense/qwe", []);
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
     * api/expense/create [POST]
     */
    public function testShouldCreateExpense(){

        $data = ['description' => 'House Rent For '.date('M') , 'group_id' => '1' , 'payer_id' => '1' ,'amount' => '6000.00'];    
        $this->post("api/expense/create", $data);
        $this->seeStatusCode(201);
        $this->seeJsonStructure(
            ['data' =>
                [
                    "description",
                    "group_id",
                    "payer_id",
                    "amount",
                    "updated_at",
                    "created_at",
                    "id"
                ]
            ]    
        );
    }

    /**
     * api/expense/create [POST]
     */
    public function testShouldCreateExpenseValidationError(){

        $data = ['description' => 'House Rent For '.date('M') , 'group_id' => 'qwe' , 'payer_id' => '1' ,'amount' => '6000.00'];    
        $this->post("api/expense/create", $data);
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
     * api/expense/users/user_id [GET]
     */
    public function testShouldReturnUserGroupWiseExpense(){
        $this->get("api/expense/users/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' => ['*' =>
                    [
                        "group_name",
                        "group_id",
                        "my_user_id",
                        "total_group_expense",
                        "my_paid_amount",
                        "my_receivable_amount",
                        "my_payable_amount",
                        "my_balance_amount",
                        "expense_details" => ['*' =>
                          [
                            "id",
                            "description",
                            "amount",
                            "payer_id",
                            "group_id",
                            "created_at",
                            "updated_at",
                            "payer_name",
                            "group_name"
                          ],
                        ]
                    ],
                ]
                
            ]    
        );
        
    }

     /**
     * api/expense/users/user_id [GET]
     */
    public function testShouldReturnUserGroupWiseExpenseValidationError(){
        $this->get("api/expense/users/qwe", []);
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
     * api/expense/groups/group_id [GET]
     */
    public function testShouldReturnGroupBalance(){
        $this->get("api/expense/groups/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' => ['*' =>
                    [
                        "group_name",
                        "total_group_expense",
                        "group_id",
                        "user_id",
                        "name",
                        "my_paid_amount",
                        "my_receivable_amount",
                        "my_payable_amount",
                        "my_balance_amount"
                        
                    ],
                ]
                
            ]    
        );
        
    }

     /**
     * api/expense/groups/group_id [GET]
     */
    public function testShouldReturnGroupBalanceValidationError(){
        $this->get("api/expense/groups/qwe", []);
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
