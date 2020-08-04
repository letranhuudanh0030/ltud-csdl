<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomersResource;
use App\Http\Resources\EventsResource;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
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
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of customers
     */
    public function index()
    {
        return CustomersResource::collection(Customer::orderBy('created_at', 'desc')->paginate(10)); 
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
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns Customer
     */
    public function store(Request $request)
    {
        $customer = Customer::create($request->all());
        return response($customer, 200);
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
     *           {"api_key_security_example": {}}
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
     *             "oauth2_security_example": {"write:roles", "read:roles"}
     *         }
     *     },
     * )
     */
    public function showEvent($id)
    {
        return EventsResource::collection(Event::where('customer_id', $id)->paginate(10));
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
     *      path="/api/customers/{id}",
     *      operationId="updateCustomer",
     *      tags={"Customers"},
     *      summary="Update Customer",
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
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns user
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return $customer;
    }

    /**
     * @OA\Delete(
     *      path="/api/customers/{id}",
     *      operationId="deleteCustomer",
     *      tags={"Customers"},
     *      summary="Delete Customer",
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
     *           {"api_key_security_example": {}}
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
