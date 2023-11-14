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
    public function find(int $id) {
        $talent = Talent::find($id);
        if($talent) {
            $talent = Talent::find($id)::with('skills')->get();
            return response()->json(['data' => $talent[0], 'status' => 200], 200 );
        }
        else {
            return response()->json(['data' => null, 'status' => 404, 'message'=>'no talent found for id='. $id], 404 );
        }
    }

    /**
     * route : GET /talents/search/{$skillid}
     * search Talent by skill
     */
    public function searchBySkills(Request $request) {
        $skill = strtolower($request->skill_title);
        if($skill === 'all') {
            $talents = Talent::with('skills')->get();
        }
        else {
            $talents = Talent::with('skills')
                ->whereHas('skills', function ($query) use ($request) {
                    $query->where('title', 'like', $request->skill_title.'%');
                    })
                ->get();
        }
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
