<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExpenseService;
use App\Validators\ExpenseValidation;
use App\Validators\GroupValidation;
use App\Validators\UserValidation;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseDetailsResource;
use App\Http\Resources\UserBalanceResource;
use App\Helpers\ResponseHelper;

class ExpenseController extends Controller
{
    
    
    /** var import expense services */
    protected $expenseService;
    /** var import expense validator */
    protected $expenseValidation;
    /** var import group validator */
    protected $groupValidation;
    /** var import user validator */
    protected $userValidation;
 
    public function __construct(ExpenseService $expenseService,
                                ExpenseValidation $expenseValidation,
                                GroupValidation $groupValidation,
                                UserValidation $userValidation)
    { 
        $this->expenseService = $expenseService;
        $this->expenseValidation = $expenseValidation;
        $this->groupValidation = $groupValidation;
        $this->userValidation = $userValidation;
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

   

   /**
     * @OA\Post(
     *     path="/api/expense/create",
     *     summary="Create an Expense",
     *     description="Expense can be created with description , group_id ,  payer_id and amount",
     *     operationId="addExpense",
     *     tags={"Expenses"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="group_id",
     *                     type="int"
     *                 ),
     *                 @OA\Property(
     *                     property="payer_id",
     *                     type="int"
     *                 ),                        
     *                 @OA\Property(
     *                     property="amount",
     *                     type="number"
     *                 ),                        
     *                 example={"description": "Friday Night Party", "group_id": "1", "payer_id": "1", "amount": "1500.00"}
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *         response=201,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The expense creation failed"
     *     ),
     * )
     */
    public function store(Request $request)
    {

        $validation = \Validator::make($request->all(), $this->expenseValidation->getRules());
       
        if ($validation->fails()) {
            
            $response_code = 422;
            $response = ResponseHelper::failedResponse("The expense creation failed ", $response_code , $validation->errors());

        }else{
             
            $expense = $this->expenseService->store($request->all());
            
            $response_code = 201;
            $response = ResponseHelper::successResponse($expense, $response_code, "Expense created Successfully!");
        }
       

        return response()->json($response, $response_code);
    }

   /**
     * @OA\Get(
     *     path="/api/expense/{group_id}",
     *     summary="Get a Group Expense Details",
     *     description="Get group expense details",
     *     operationId="FetchGroupExp",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="group_id",
     *         in="path",
     *         description="Fetch the Group with its id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     * )
     */
    public function show($group_id)
    {
        
        $validation = \Validator::make(['group_id' => $group_id], $this->groupValidation->isGroup());

        if ($validation->fails()) {

            $response_code = 200;

            $response = ResponseHelper::failedResponse("Group not found ! ", $response_code ,[]);
      
        }else{

            $group_expense = ExpenseDetailsResource::collection($this->expenseService->getGroupExpenses($group_id));

            $response_code = 200;

            $response = ResponseHelper::successResponse($group_expense, $response_code, "Group wise Expense Fetched Successfully!");           
        }

        return response()->json($response, $response_code);
    }

    /**
     * @OA\Get(
     *     path="/api/expense/users/{user_id}",
     *     summary="Get Full spend and payable of my group wise ",
     *     description="Group wise paid and payable amounts",
     *     operationId="FetchUserGroupExp",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="Fetch User wise Expenses & Payables",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     * )
     */
    public function showGroupExpense($user_id)
    {

        $validation = \Validator::make(['user_id' => $user_id], $this->userValidation->isUser());
  
        if ($validation->fails()) {

            $response_code = 200;
            $response = ResponseHelper::failedResponse("User not found ! ", $response_code ,[]);

        }else{

            $user_expense = ExpenseResource::collection($this->expenseService->getUserExpenses($user_id));
            $response_code = 200;
            $response = ResponseHelper::successResponse($user_expense, $response_code, "User wise Expense Fetched Successfully!");
        }

        return response()->json($response, $response_code);
    }

    /**
     * @OA\Get(
     *     path="/api/expense/groups/{group_id}",
     *     summary="User wise balance details in a group",
     *     description="User wise balance details in a group",
     *     operationId="FetchUserBalance",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="group_id",
     *         in="path",
     *         description="Users balance group wise",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     * )
     */
    public function showGroupBalance($group_id)
    {

        $validation = \Validator::make(['group_id' => $group_id], $this->groupValidation->isGroup());

        if ($validation->fails()) {

            $response_code = 200;
            $response = ResponseHelper::failedResponse("Group not found ! ", $response_code ,[]);
           
        }else{

            $user_balance =UserBalanceResource::collection($this->expenseService->getGroupExpenseUserWise($group_id));

            $response_code = 200;
            $response = ResponseHelper::successResponse($user_balance, $response_code, "User wise Group Expense Fetched Successfully!");
        }

        return response()->json($response, $response_code);
    }

   
}
