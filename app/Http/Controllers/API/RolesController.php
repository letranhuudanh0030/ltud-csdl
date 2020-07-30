<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResource;
use App\Http\Resources\UsersResource;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/roles",
     *      operationId="getRolessList",
     *      tags={"Roles"},
     *      summary="Get list of roles",
     *      description="Returns list of roles",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of roles
     */
    public function index()
    {
        return RolesResource::collection(Role::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/api/roles",
     *      operationId="addRole",
     *      tags={"Roles"},
     *      summary="Add a new role to the store",
     *      @OA\Parameter(
     *          name="name",
     *          description="Name Role",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="level_role",
     *          description="Role Level",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Role Status",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",            
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="selectStatus",
     *         in="query",
     *         description="Status values that need to be considered for filter",
     *         required=true,
     *         style="form",
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 default="available",
     *                 enum={1,2,3},
     *             ) 
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:roles", "read:roles"}
     *         }
     *     },
     * )
     */
    public function store(Request $request)
    {
        $role = Role::create($request->all());
        return new RolesResource(Role::find($role->id));
        // return $request->all();
    }

    /**
     * @OA\Get(
     *      path="/api/roles/{id}/users",
     *      operationId="role_users",
     *      tags={"Roles"},
     *      summary="Show User Belong To Role ID",
     *      description="Returns Users data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Role ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:roles", "read:roles"}
     *         }
     *     },
     * )
     */
    public function showUser($id)
    {
        return UsersResource::collection(User::where('role_id', $id)->paginate(5));
    }

    /**
     * @OA\Get(
     *      path="/api/roles/{id}",
     *      operationId="getRoleDetail",
     *      tags={"Roles"},
     *      summary="Show Role Detail",
     *      description="Returns Role Detail",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:roles", "read:roles"}
     *         }
     *     },
     * )
     */
    public function show($id)
    {
        return new RolesResource(Role::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/api/roles/{id}",
     *      operationId="role update",
     *      tags={"Roles"},
     *      summary="Update Role",
     *      description="Returns Roles data",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID Role",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Name Role",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="level_role",
     *          description="Role Level",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Role Status",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",            
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:roles", "read:roles"}
     *         }
     *     },
     * )
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return $role;
    }

    /**
     * @OA\Delete(
     *      path="/api/roles/{id}",
     *      operationId="role delete",
     *      tags={"Roles"},
     *      summary="Delete Role",
     *      description="Returns Roles data",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID Role",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:roles", "read:roles"}
     *         }
     *     },
     * )
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response('Delete Role Success', 200);
    }
}
