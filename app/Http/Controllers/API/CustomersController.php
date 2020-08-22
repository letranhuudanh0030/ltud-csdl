<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomersResource;
use App\Http\Resources\EventsResource;
use App\Mail\ConfirmCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomersController extends Controller
{

    public function __construct()
    {
        // $this->middleware('checkRole');
    }

    /**
     * @OA\Get(
     *      path="/api/customers",
     *      operationId="getCustomersList",
     *      tags={"Customers"},
     *      summary="Get list of customers",
     *      description="Returns list of customers",
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
     * Returns list of customers
     */
    public function index()
    {   
        return CustomersResource::collection(Customer::with('event')->orderBy('created_at', 'desc')->paginate(100)); 
    }

    /**
     * @OA\Post(
     *      path="/api/customers",
     *      operationId="addCustomer",
     *      tags={"Customers"},
     *      summary="Add a new customer",
     *      @OA\RequestBody(
     *          description="Customer object that needs to be added to the store",
     *          required=true,
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Customer"
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
     * Returns Customer
     */
    public function store(Request $request)
    {
        // return $request->all();
        $customer = Customer::create($request->except('event'));
        if($request->event){
            $eventReq = $request->event;
            $eventReq['customer_id'] = $customer->id;
            $eventReq['time_start'] = Carbon::createFromFormat('Y-m-d H:i:s',$eventReq['time_start'], 'UTC');
            $eventReq['time_end'] = Carbon::createFromFormat('Y-m-d H:i:s',$eventReq['time_end'], 'UTC');
            $request->merge([
                'event' => $eventReq
            ]);
            $event = Event::create($eventReq);
        }
        return response('Created successfully!', 200 );
    }

    /**
     * @OA\Get(
     *      path="/api/customers/{id}",
     *      operationId="getCustomer",
     *      tags={"Customers"},
     *      summary="Show Customer Detail",
     *      description="Returns Customer",
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
     * Returns customer
     */
    public function show($id)
    {
        return new CustomersResource(Customer::findOrFail($id));
    }

    /**
     * @OA\Get(
     *      path="/api/customers/{id}/events",
     *      operationId="customer_events",
     *      tags={"Customers"},
     *      summary="Show Events Belong To Customer ID",
     *      description="Returns event list data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Customer ID",
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
     *             "api_key": {}
     *         }
     *     },
     * )
     */
    public function showEvent($id)
    {
        return EventsResource::collection(Event::where('customer_id', $id)->paginate(10));
    }

    /**
     * @OA\Put(
     *      path="/api/customers/{id}",
     *      operationId="updateCustomer",
     *      tags={"Customers"},
     *      summary="Update Customer",
     *      description="Returns customer data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Customer ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Customer object that needs to be added to the update",
     *          required=true,
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Customer"
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
     * Returns customer
     */
    public function update(Request $request, $id)
    {
        
        $customer = Customer::findOrFail($id);
        $customer->update($request->except('event'));
        if($request->event){
            $event = Event::where('customer_id', $customer->id)->first();
            $eventReq = $request->event;
            if($event){
                $event->update($eventReq);
            } else{
                $eventReq['customer_id'] = $customer->id;
                $request->merge([
                    'event' => $eventReq
                ]);
                $event = Event::create($eventReq);
            }
        }
        return response($customer, 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/customers/{id}",
     *      operationId="deleteCustomer",
     *      tags={"Customers"},
     *      summary="Delete Customer",
     *      description="Returns customer data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Customer ID",
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
     * Returns customer
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response($customer->name . ' has been deleted!', 200);
    }
}
