<?php

namespace App\Http\Controllers;
use App\Models\Talent;
use App\Models\Skill;
use Illuminate\Http\Request;

class TalentController extends Controller
{
    /**
     * route : GET /talents
     * Get all talents
     */
    public function index() {
        $talents = Talent::with('skills')->get();
        return response()->json([
            'data' => $talents,
            'status' => 200
        ],
        200
        );
    }

    /**
     * route : GET /talents/{$id}
     * Get a talent by id
     */
    public function find(Request $request) {
        $talent = Talent::find($request->id)::with('skills')->get();
        return response()->json(['data' => $talent, 'status' => 200], 200 );
    }

    /**
     * route : GET /talents/search/{$skillid}
     * search Talent by skill
     */
    public function searchBySkills(Request $request) {
        $skill = Skill::find($request->skillid);
        $talents = $skill->talents()->get();
        return response()->json(['data' => $talents, 'status' => 200], 200 );
    }

    /**
     * route : POST /talents
     * Create and store a new talent
     */
    public function create(Request $request) {
        $talent = new Talent();
        $talent->last       = $request->last;
        $talent->first      = $request->first;
        $talent->xp         = $request->xp;
        $talent->tjm        = $request->tjm;
        $talent->city       = $request->city;
        $talent->country    = $request->country;
        $talent->remote     = $request->remote;
        $talent->linkedin   = $request->linkedin ;
        $talent->indicatifphone = $request->indicatifphone;
        $talent->phone      = $request->phone;
        $talent->email      = $request->email;
        $isSavedTalent         = $talent->save();
        if($isSavedTalent) {
            return response()->json([
                'message' => 'Talent created successfuly',
                'data' => $talent,
                'status' => 201
                ], 
                201
            );
        }
    }
    
    /**
     * route : PATCH /talents/{$id}
     * patch fields for an existing talent
     */
    public function patch(int $id, Request $request) {
        $talent = Talent::findOrFail($id);
        $requestData = $request->all();
        $talent->update($requestData);
        return response()->json([
            'message' => 'Talent updated successfully',
            'data' => $talent,
            'status' => 200
        ],
        200
        );
    }

    /**
     * route : DELETE /talents/{$id}
     * delete a talent
     */
    public function delete(int $id) {
        $talent = Talent::find($id);
        $isDeletedJob = $talent->delete();
        if($isDeletedJob) {
            return response()->json([
                'message' => 'Talent deleted',
                'id' => $talent->id,
                'status' => 200
            ],
            200
        );
        }
    }
}
