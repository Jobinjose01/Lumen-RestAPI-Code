<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Validators\GroupValidation;
use App\Helpers\ResponseHelper;

class GroupController extends Controller
{
    
     /** var import user services */
     protected $groupService;
     /** var import user validator */
     protected $groupValidation;

     public function __construct(GroupService $groupService , GroupValidation $groupValidation){

        $this->groupService = $groupService;
        $this->groupValidation = $groupValidation;
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
     *     path="/api/groups/create",
     *     summary="Create new groups in the system",
     *     description="Add a new group",
     *     operationId="addGroup",
     *     tags={"Groups"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                example={"name": "House Rent"}
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

        $validation = \Validator::make($request->all(), $this->groupValidation->getRules());
       
        if ($validation->fails()) {
            
            $response_code = 422;
            $response = ResponseHelper::failedResponse("Group Name already taken", $response_code , $validation->errors());

        }else{
             
            $group = $this->groupService->store($request->all());
            
            $response_code = 201;
            $response = ResponseHelper::successResponse($group, $response_code, "Group created Successfully!");
        }
       

        return response()->json($response, $response_code);
    }

    /**
     * @OA\Get(
     *     path="/api/groups/{id}",
     *     summary="Get a Group Details",
     *     description="Get group details",
     *     operationId="FetchGroup",
     *     tags={"Groups"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Fetch the Group with its id",
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
        
        $validation = \Validator::make(['group_id' => $id], $this->groupValidation->isGroup());
  
        if ($validation->fails()) {

            $response_code = 200;
            $response = ResponseHelper::failedResponse("Group not found!", $response_code , $validation->errors());
           
        }else{
            $group = $this->groupService->findGroup($id);
            $response_code = 200;
            $response = ResponseHelper::successResponse($group, $response_code, "Group fetched Successfully!");
           
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
