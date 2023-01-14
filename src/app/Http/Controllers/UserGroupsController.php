<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserGroupService;
use App\Validators\UserGroupValidation;
use App\Helpers\ResponseHelper;


class UserGroupsController extends Controller
{
    //** var import user group services */
    protected $usergroupService;
    /** var import user group validator */
    protected $usergroupValidation;

    public function __construct(UserGroupService $usergroupService , UserGroupValidation $usergroupValidation){

       $this->usergroupService = $usergroupService;
       $this->usergroupValidation = $usergroupValidation;
   }


   /**
     * @OA\Post(
     *     path="/api/usergroups/create",
     *     summary="Assign a user to a group",
     *     description="Add a user to a group",
     *     operationId="addUserToGroup",
     *     tags={"Add User to Group"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="group_id",
     *                     type="string"
     *                 ),                      
     *                 example={"user_id": "2", "group_id": "1"}
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

        $validation = \Validator::make($request->all(), $this->usergroupValidation->getRules());
       
        if ($validation->fails()) {
            
            $response_code = 422;
            $response = ResponseHelper::failedResponse("The user can't assign to the group or already assigned", $response_code , $validation->errors());

        }else{
             
            $user = $this->usergroupService->store($request->all());
            
            $response_code = 201;
            $response = ResponseHelper::successResponse($user, $response_code, "User Assigned to the Group Successfully!");
        }
       

        return response()->json($response, $response_code);
    }


}
