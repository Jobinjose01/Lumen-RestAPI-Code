<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use App\Validators\UserValidation;
use App\Helpers\ResponseHelper;

class AuthController extends Controller
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
         *     path="/api/users/authendicate",
         *     summary="Authendicate a user and return the token",
         *     description="User Authendication will return the token, for easy to keep the testing now token header implementation is not done",
         *     operationId="authUser",
         *     tags={"User"},
         *     @OA\RequestBody(
         *         @OA\MediaType(
         *             mediaType="application/json",
         *             @OA\Schema(
         *                 @OA\Property(
         *                     property="username",
         *                     type="string"
         *                 ),
         *                 @OA\Property(
         *                     property="password",
         *                     type="string"
         *                 ),
         *                 example={"username": "admin", "password": "123456"}
         *             )
         *         )
         *     ),
         *      @OA\Response(
         *         response=200,
         *         description="successful operation",
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Invalid user login attempt"
         *     ),
         * )
         */
        public function authendicate(Request $request){
             
            $validation = \Validator::make($request->all(), $this->userValidation->getAuthendicate());

            if ($validation->fails()) {
                $response_code = 422;
                $response = ResponseHelper::failedResponse("Login attempt failed", $response_code , $validation->errors());

            }else{

                $result = $this->userService->authendicate($request->all());
                
                if(!empty($result)){
                    $response_code = 200;
                    $response = ResponseHelper::successResponse($result, $response_code, "User login Successfully!");
                }else{
                    $response_code = 422;
                    $response = ResponseHelper::failedResponse("Invalid login details", $response_code , $validation->errors());
                }
            }

            return response()->json($response, $response_code);
        }


        
}
