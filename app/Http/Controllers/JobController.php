<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    /**
     * route : GET /jobs
     * Get jobs
     */
    public function index(Request $request) {
        if ($request->filled('withcustomer')) {
            if($request->query('withcustomer') == true) {
                $jobs = Job::with('customer', 'skills')->get();
            }
        }

        else {
            $jobs = Job::all();

        }
        return response()->json([
            'data' => $jobs,
            'status' => 200],
        200
    );
    }

    /**
     * route : GET /jobs/{$id}
     * Get job
     */
    public function find(int $id) {
        $jobs = Job::find($id);
        return response()->json([
            'data' => $job, 
            'status' => 200], 
            200 
        );
    }

    /**
     * route : POST /jobs
     * Create and store a new job
     */
    public function create(Request $request) {
        $job = new Job();
        $job->customer_id   = $request->customer_id;
        $job->title         = $request->title;
        $job->description   = $request->description;
        $job->isRemote      = $request->isRemote;
        $job->duration      = $request->duration;
        $job->tjmin         = $request->tjmin;
        $job->tjmax         = $request->tjmax;
        $job->startDate     = $request->startDate;
        $job->city          = $request->city;
        $job->country       = $request->country;
        $job->info          = $request->info;
        $job->status        = $request->status;
        $isSavedJob         = $job->save();
        if($isSavedJob) {
            return response()->json([
                'message' => 'Job created successfuly',
                'data' => $job,
                'status' => 201
                ], 
                201
            );
        }
    }
    
    /**
     * route : PATCH /jobs/{$id}
     * patch fields for an existing job 
     */
    public function patch(int $id, Request $request) {
        $job = Job::findOrFail($id);
        $requestData = $request->all();
        $job->update($requestData);
        $customer = $job->customer;
        return response()->json([
            'message' => 'Job updated successfully',
            'data' => $job,
            'status' => 200
        ],
        200
        );
    }

    /**
     * route : DELETE /jobs/{$id}
     * delete a job
     */
    public function delete(int $id) {
        $job = Job::find($id);
        $isDeletedJob = $job->delete();
        if($isDeletedJob) {
            return response()->json([
                'message' => 'Job deleted',
                'id' => $job->id,
                'status' => 200
            ],
            200
        );
        }
    }

     /**
     * route : POST /jobs/{$id}/skills
     * add a skill for a job (in skillables table)
     */
    public function addSkill(int $id, Request $request): JsonResponse {
        $job = Job::find($id);
        $skillExists = $job->skills()->where('skill_id', $request->skill_id)->first();
        if($skillExists) {
            return response()->json(['message' => 'Skill already exists for this job', 'status' => 422], 422 );
        }
        $skill = Skill::find($request->skill_id);
        $job->skills()->attach($skill);
        return response()->json(['data' =>  $job->skills , 'status' => 201], 201 ); 
    }

    /**
     * route : DELETE /jobs/{$id}/skills/{$skillId}
     * delete a skill for a job (in skillables table)
     */
    public function deleteSkill(int $id, int $skillId): JsonResponse {
        $job = Job::find($id);
        $skillExists = $job->skills()->where('skill_id', $skillId)->first();
        if(!$skillExists) {
            return response()->json(['message' => 'Skill not found', 'status' => 404], 404 );
        }
        $job->skills()->detach($skillId);
        return response()->json([
            'id'=> $skillId, 
            'message' => 'Skill removed for this job', 
            'status' => 200
        ], 200 );
        
    }
}
