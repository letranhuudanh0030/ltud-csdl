<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsResource;
use App\Http\Resources\TasksResource;
use App\Mail\RequestUser;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/events",
     *      operationId="getEventsList",
     *      tags={"Events"},
     *      summary="Get list of events",
     *      description="Returns list of events",
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
     * Returns list of events
     */
    public function index()
    {
        return EventsResource::collection(Event::orderBy('created_at', 'desc')->paginate(10));
    }


    /**
     * @OA\Post(
     *      path="/api/events",
     *      operationId="addEvent",
     *      tags={"Events"},
     *      summary="Add a new event",
     *      @OA\RequestBody(
     *          description="Event object that needs to be added to the store",
     *          required=true,
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Event"
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
     * Returns Event
     */
    public function store(Request $request)
    {
        $event = Event::create($request->all());
        return response($event->name . ' has been created!', 200);
    }

    /**
     * @OA\Get(
     *      path="/api/events/{id}",
     *      operationId="getEvent",
     *      tags={"Events"},
     *      summary="Show Event Detail",
     *      description="Returns Event",
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
     * Returns event
     */
    public function show($id)
    {
        return new EventsResource(Event::findOrFail($id));
    }

    /**
     * @OA\Get(
     *      path="/api/events/{id}/tasks",
     *      operationId="event_tasks",
     *      tags={"Events"},
     *      summary="Show Tasks Belong To Event ID",
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
        return TasksResource::collection(Task::where('event_id', $id)->paginate(10));
    }

    /**
     * @OA\Put(
     *      path="/api/events/{id}",
     *      operationId="updateEvent",
     *      tags={"Events"},
     *      summary="Update Event",
     *      description="Returns use data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Event ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Event object that needs to be added to the update",
     *          required=true,
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Event"
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
     * Returns event
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return $event;
    }

    /**
     * @OA\Delete(
     *      path="/api/events/{id}",
     *      operationId="deleteEvent",
     *      tags={"Events"},
     *      summary="Delete event",
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
     * Returns event
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response($event->name . ' has been deleted!', 200);
    }

    /**
     * @OA\Post(
     *      path="/api/events/{id}/users",
     *      operationId="addEventUsers",
     *      tags={"Events"},
     *      summary="Add users to event",
     *      @OA\Parameter(
     *          name="id",
     *          description="Event ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="User object that needs to be added to the store",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="ids", 
     *                  type="array",
     *                  @OA\Items()
     *              ),
     *              @OA\Property(
     *                  property="subject",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="content",
     *                  type="string"
     *              )
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
     * Returns Event
     */
    public function storeUserToEvent(Request $request, $id)
    {

        $event = Event::find($id);
        $event->user()->attach($request->ids);
        // foreach ($event->user as $user) {
        //     Mail::to($user->email)->send(new RequestUser($event, $request, $user));
        // }
        return response('Store user to event successfully!', 200);
    }


    public function changeStatus($event_id, $user_id, $status)
    {
        $created = DB::table('user_event')->where('user_id', $user_id)->where('event_id', $event_id)->first()->created_at;
        $update_status = null;
        if(!$created) {
            $update_status = DB::table('user_event')->where('user_id', $user_id)->where('event_id', $event_id)->update(['status' => $status, 'created_at' => now()]);
        }
        if($update_status){
            redirect(url('/decline'));
        }else{
            redirect(url('/accept'));        
        }
    }
}
