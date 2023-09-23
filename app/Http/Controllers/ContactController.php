<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * route : GET /contacts
     * Get contacts
     */
    public function index() {
        $contacts = Contact::all();
        return response()->json([
            'data' => $contacts,
            'status' => 200
        ], 200);
    }

    /**
     * route : GET /contacts/{$id}
     * Get contacts
     */
    public function find(int $id) {
        $contact = Contact::find($id);
        return response()->json([
            'data' => $contact,
            'status' => 200
        ], 200);
    }

    /**
     * route : POST /contacts
     * Create and store a new contact
     */
    public function create(Request $request) {
        $contact = new Contact();
        $contact->customer_id   = $request->customer_id;
        $contact->last          = $request->last;
        $contact->first         = $request->first;
        $contact->indicatifphone = $request->indicatifphone;
        $contact->phone         = $request->phone ;
        $contact->email         = $request->email;
        $contact->linkedin      = $request->linkedin;
        $isSavedContact         = $contact->save();
        if($isSavedContact) {
            return response()->json([
                'message' => 'Contact created successfuly',
                'data' => $contact,
                'status' => 201
                ], 
                201
            );
        }
    }

    /**
     * route : PATCH /contacts/{$id}
     * patch fields for an existing contact
     */
    public function patch(int $id, Request $request) {
        $contact = Contact::findOrFail($id);
        $requestData = $request->all();
        $contact->update($requestData);
        return response()->json([
            'message' => 'Contact updated successfully',
            'data' => $contact,
            'status' => 200
        ],
        200
        );
    }

    /**
     * route : DELETE /contacts/{$id}
     * delete a contact
     */
    public function delete(int $id) {
        $contact = Contact::find($id);
        $isDeletedContact = $contact->delete();
        if($isDeletedContact) {
            return response()->json([
                'message' => 'contact deleted',
                'id' => $contact->id,
                'status' => 200
            ],
            200
        );
        }
    }
}
