<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   /**
     * route : GET /customers
     * Get customers
     */
    public function index() {
        $customers = Customer::all();
        return response()->json([
            'data' => $customers,
            'status' => 200
        ],
        200
        );
    }

    /**
     * route : GET /customers/{$id}
     * route : GET /customers/{$id}?withcontacts=true
     * Get customer
     */
    public function find(int $id, Request $request) {
        
        if($request->withcontacts && $request->withcontacts == 'true') {
            $customer = Customer::with('contacts')->find($id);
        } else {
            $customer = Customer::find($id);
        }
        return response()->json([
            'data' => $customer,
            'status' => 200],
            200 );
    }

    /**
     * route : POST /customers
     * Create and store a new customer
     */
    public function create(Request $request) {
        $customer = new Customer();
        $customer->name     = $request->name;
        $customer->type     = $request->type;
        $customer->isorganismeformation = $request->isorganismeformation;
        $customer->siren    = $request->siren;
        $customer->nic      = $request->nic;
        $customer->siret    = $request->siret;
        $customer->address  = $request->address;
        $customer->complementaddress = $request->complementaddress;
        $customer->cp       = $request->cp;
        $customer->city     = $request->city;
        $customer->country  = $request->country;
        $isSavedCustomer    = $customer->save();
        if($isSavedCustomer) {
            return response()->json([
                'message' => 'Customer created successfuly',
                'data' => $customer,
                'status' => 201
                ], 
                201
            );
        }
    }
    
    /**
     * route : PATCH /customers/{$id}
     * patch fields for an existing customer
     */
    public function patch(int $id, Request $request) {
        $customer = Customer::findOrFail($id);
        $requestData = $request->all();
        $customer->update($requestData);
        return response()->json([
            'message' => 'Customer updated successfully',
            'data' => $customer,
            'status' => 200
        ],
        200
        );
    }

    /**
     * route : DELETE /customers/{$id}
     * delete a customer
     */
    public function delete(int $id) {
        $customer = Customer::find($id);
        $isDeletedCustomer = $customer->delete();
        if($isDeletedCustomer) {
            return response()->json([
                'message' => 'Customer deleted',
                'id' => $customer->id,
                'status' => 200
            ],
            200
        );
        }
    }
}
