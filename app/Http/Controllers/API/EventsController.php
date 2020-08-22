<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsResource;
use App\Http\Resources\TasksResource;
use App\Mail\RequestUser;
use App\Task;
use App\User;
use Carbon\Carbon;
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
        return EventsResource::collection(Event::orderBy('created_at', 'desc')->paginate(100));
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
     *              ref="#/components/schemas/Event",
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
        // return $event->user->first()->pivot->created_at;
        $event->update($request->all());
        if($event->status == 1){
            $customer = Customer::findOrFail($event->customer->id);
            $customer->status = 1;
            $customer->save();
        }

        if($request->ids && $event){
            $event->user()->sync($request->ids);
            foreach ($event->user as $user) {
                if(!DB::table('user_event')->where('user_id', $user->id)->first()->created_at){
                    Mail::to($user->email)->send(new RequestUser($event, $request, $user));
                }
            }
        }
        $eventRes = new EventsResource($event);
        return response($eventRes, 200);
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
        if($request->ids){
            foreach ($request->ids as $id) {
                Mail::to(User::findOrFail($id)->email)->send(new RequestUser($event, $request, User::findOrFail($id)));
            }   
        }
        // $event->user()->sync($request->ids);
        
        return response('Store user to event successfully!', 200);
    }

    public function sendMail(Request $request)
    {
        
        // foreach ($event->user as $user) {
        //     Mail::to($user->email)->send(new RequestUser($event, $request, $user));
        // }
    }

    /**
     * @OA\Post(
     *      path="/api/events/{event_id}/users/{user_id}",
     *      operationId="addTaskUsers",
     *      tags={"Events"},
     *      summary="Add task for user",
     *      @OA\Parameter(
     *          name="event_id",
     *          description="Event ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Task information",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="name",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="content",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="task_start",
     *                  type="string",
     *                  format="date-time"
     *              ),
     *              @OA\Property(
     *                  property="task_end",
     *                  type="string",
     *                  format="date-time"
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
    public function storeTaskForUser(Request $request, $event_id, $user_id)
    {
        $request->merge([
            'event_id' => $event_id,
            'user_id' => $user_id,
            'task_start' => Carbon::create($request->task_start, 'UTC')->format('Y-m-d H:i:s'),
            'task_end' => Carbon::create($request->task_end, 'UTC')->format('Y-m-d H:i:s')
        ]);

        // return $request->all();
        $task = Task::create($request->all());
        return $task;
    }

    public function changeStatus($event_id, $user_id, $status)
    {
        $created = DB::table('user_event')->where('user_id', $user_id)->where('event_id', $event_id)->first();
        $update_status = null;
        if(!$created) {
            $event = Event::findOrFail($event_id);
            $event->user()->attach($user_id);
            $update_status = DB::table('user_event')->where('user_id', $user_id)->where('event_id', $event_id)->update(['status' => $status, 'created_at' => now()]);
        }

        if($update_status == null){
            return redirect()->route('message-response')->with('message', 'Email này đã được xác nhận. Không thể thao tác tiếp !')
                                                        ->with('alert', 'Cảnh báo !')
                                                        ->with('color', 'red');  
        }else{
            if($status == 1){
                return redirect()->route('message-response')->with('message', 'Bạn đã đồng ý tham gia vào event '.Event::find($event_id)['name'].' !')
                                                            ->with('alert', 'Thành công !')
                                                            ->with('color', 'green');      
            } else {
                return redirect()->route('message-response')->with('message', 'Bạn đã từ chối tham gia vào event '.Event::find($event_id)['name'].' !')
                                                            ->with('alert', 'Từ chối thành công !')
                                                            ->with('color', 'red'); 
            }
        }
        
    }
}
