<?php

namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * route : GET /jobs
     * Get jobs
     */
    public function index() {
        $jobs = Job::all();
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
}
