<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Validators\UserValidation;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Splitwise Backend API", version="0.1")
 */
class OpenApi {}

class UserController extends Controller
{

    /** var import user services */
    protected $userService;
    /** var import user validator */
    protected $userValidation;

    public function __construct(UserService $userService , UserValidation $userValidation){

        $this->userService = $userService;
        $this->userValidation = $userValidation;
    }

   

    
    /**
     * @OA\Post(
     *     path="/api/users/create",
     *     summary="Create new user in the system",
     *     description="Add a new user",
     *     operationId="addUser",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"name": "Jessica Smith", "username": "Jessica", "password": "12345678"}
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *         response=201,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Failed operation user already exist"
     *     ),
     * )
     */
    public function store(Request $request)
    {

        $validation = \Validator::make($request->all(), $this->userValidation->getRules());
       
        if ($validation->fails()) {
            
            $response_code = 422;
            $response = ResponseHelper::failedResponse("User Creation failed", $response_code , $validation->errors());

        }else{
             
            $user = $this->userService->store($request->all());
            
            $response_code = 201;
            $response = ResponseHelper::successResponse($user, $response_code, "User created Successfully!");
        }
       

        return response()->json($response, $response_code);
    }

     /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Fetch the users from the system using ID",
     *     description="Get user details",
     *     operationId="FetchUser",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Fetch the user with its id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *         response=201,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     ),
     * )
     */
    public function show($id)
    {

        $validation = \Validator::make(['user_id' => $id], $this->userValidation->isUser());
  
        if ($validation->fails()) {

            $response_code = 200;
            $response = ResponseHelper::failedResponse("User not found!", $response_code , $validation->errors());
           
        }else{
            $user = $this->userService->findUser($id);
            $response_code = 200;
            $response = ResponseHelper::successResponse($user, $response_code, "User fetched Successfully!");
           
        }

        return response()->json($response, $response_code);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
