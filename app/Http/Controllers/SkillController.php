<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * route : GET /skills
     * Get skills
     */
    public function index() {
        $skills = Skill::all();
        return response()->json([
            'data' => $skills,
            'status' => 200
        ], 200);
    }

    /**
     * route : GET /Skills/{$id}
     * Get Skills
     */
    public function find(int $id) {
        $skill = Skill::find($id);
        return response()->json([
            'data' => $skill,
            'status' => 200
        ], 200);
    }

    /**
     * route : POST /skills
     * Create and store a new skill
     */
    public function create(Request $request) {
        $skill = new Skill();
        $skill->customer_id   = $request->customer_id;
        $skill->last          = $request->last;
        $skill->first         = $request->first;
        $skill->indicatifphone = $request->indicatifphone;
        $skill->phone         = $request->phone ;
        $skill->email         = $request->email;
        $skill->linkedin      = $request->linkedin;
        $isSavedSkill         = $skill->save();
        if($isSavedSkill) {
            return response()->json([
                'message' => 'Skill created successfuly',
                'data' => $skill,
                'status' => 201
                ], 
                201
            );
        }
    }

    /**
     * route : PATCH /skills/{$id}
     * patch fields for an existing skill
     */
    public function patch(int $id, Request $request) {
        $skill = Skill::findOrFail($id);
        $requestData = $request->all();
        $skill->update($requestData);
        return response()->json([
            'message' => 'Skill updated successfully',
            'data' => $skill,
            'status' => 200
        ],
        200
        );
    }

    /**
     * route : DELETE /skills/{$id}
     * delete a skill
     */
    public function delete(int $id) {
        $skill = Skill::find($id);
        $isDeletedSkill = $skill->delete();
        if($isDeletedSkill) {
            return response()->json([
                'message' => 'Skill deleted',
                'id' => $skill->id,
                'status' => 200
            ],
            200
        );
        }
    }
}
