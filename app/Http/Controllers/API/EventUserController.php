<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\EventUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventUserResource;
use App\Http\Resources\EventsResource;
use Illuminate\Http\Request;

class EventUserController extends Controller
{
    public function store(Request $request)
    {
        $eventUser = EventUser::create($request->all());
        return response($eventUser, 200);
    }
    public function showUserOfEvent($event_id)
    {
        return EventsResource::collection(EventUser::where('event_id', $event_id)->paginate(10));
    }

    public function showEventOfUser($user_id)
    {
        return EventsResource::collection(EventUser::where('user_id', $user_id)->paginate(10));
    }

    public function update(Request $request, $event_id,$user_id)
    {
        $eventUser = EventUser::where(['event_id',"=",$event_id],'user_id',"=",$user_id);
        $eventUser->update($request->all());
        return response($eventUser, 200);
    }
    public function destroyEvent($event_id,$user_id)
    {
        $eventUser = EventUser::where(['event_id',"=",$event_id]);
        $eventUser->delete();
        return response($eventUser->event_id . ' has been deleted!', 200);
    }
    public function destroyUserOfEvent($event_id,$user_id)
    {
        $eventUser = EventUser::where(['event_id',"=",$event_id],'user_id',"=",$user_id);
        $eventUser->delete();
        return response($eventUser->user_id . ' has been deleted!', 200);
    }
}
