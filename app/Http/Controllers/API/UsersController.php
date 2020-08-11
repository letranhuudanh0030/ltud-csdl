<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TasksResource;
use App\Http\Resources\UsersResource;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key": {123}}
     *       }
     *     )
     *
     * Returns list of users
     */
    public function index()
    {
        $users = User::with('role')->orderBy('created_at','desc')->paginate(10);
        return UsersResource::collection($users);
    }

    /**
     * @OA\Post(
     *      path="/api/users",
     *      operationId="addUser",
     *      tags={"Users"},
     *      summary="Add a new user",
     *      @OA\RequestBody(
     *          description="User object that needs to be added to the store",
     *          required=true,
     *          @OA\JsonContent(
     *              ref="#/components/schemas/User"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key": {}}
     *       }
     *     )
     *
     * Returns user
     */
    public function store(Request $request)
    {
        $request->merge(['uuid' => (string) Str::uuid()]);
        $request->merge(['password' => Hash::make($request->password)]);
        $user = User::create($request->all());
        $user = new UsersResource(User::find($user->id));
        return response($user, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/users/{id}",
     *      operationId="getUser",
     *      tags={"Users"},
     *      summary="Show User Detail",
     *      description="Returns user",
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
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key": {}}
     *       }
     *     )
     *
     * Returns list of users
     */
    public function show($id)
    {
        // return $id;
        return new UsersResource(User::findOrFail($id));
    }

    /**
     * @OA\Get(
     *      path="/api/users/{id}/tasks",
     *      operationId="user_tasks",
     *      tags={"Users"},
     *      summary="Show Tasks Belong To User ID",
     *      description="Returns task list data",
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
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key": {}}
     *       }
     *     )
     *
     * Returns list of task
     */
    public function showTask($id)
    {
        return TasksResource::collection(Task::where('user_id', $id)->paginate(10));
    }

    /**
     * @OA\Put(
     *      path="/api/users/{id}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update User",
     *      description="Returns use data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="User object that needs to be added to the update",
     *          required=true,
     *          @OA\JsonContent(
     *              ref="#/components/schemas/User"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key": {}}
     *       }
     *     )
     *
     * Returns user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->merge(['password' => Hash::make($request->password)]);
        $user->update($request->all());
        return $user;
    }

    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Delete User",
     *      description="Returns use data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
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
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key": {}}
     *       }
     *     )
     *
     * Returns user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response($user->name . ' has been deleted!', 200);
    }
}
