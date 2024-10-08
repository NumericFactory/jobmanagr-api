<?php

namespace App\Http\Controllers;
use App\Models\Talent;
use App\Models\Skill;
use App\Models\Resume;
use Illuminate\Http\Request;
use App\Services\UploadFileManagerService;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\Talent\UploadResumeRequest;
use App\Http\Requests\Talent\CreateTalentRequest;
use App\Http\Requests\Talent\UpdateAddressTalentRequest;


enum TalentTypeFile: string {
    case Cv = 'cv';
    case Contract = 'contrat';

}

class TalentController extends Controller
{
    /**
     * route : GET /talents
     * Get all talents
     */
    public function index(): JsonResponse {
        $talents = Talent::with('skills', 'resumes', 'contracts')->get();
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
    public function find(int $id): JsonResponse {
        $talent = Talent::with('skills', 'resumes')->where('id', $id)->get();
        if(count($talent) > 0) {
            return response()->json(['data' => $talent, 'status' => 200], 200 );
        }
        else {
            return response()->json(['data' => null, 'status' => 404, 'message'=>'no talent found for id='. $id], 404 );
        }
    }

    /**
     * route : GET /talents/search/search?
     * search Talents by skill, city, tjmMax 
     */
    public function search(Request $request): JsonResponse {
        $skill = $request->skill ? strtolower($request->skill) : null;
        $city = $request->city ? strtolower($request->city) : null;
        $tjmMax = $request->tjmMax ?  $request->tjmMax : null;
        $talents = Talent::with('skills', 'resumes')
            ->whereHas('skills', function ($query) use ($request) {
                $query->where('title', 'like', $request->skill.'%');
            }) 
            ->when($city, function ($query, string $city) {
                $query->where('city', 'like', $city);
            })
            ->when($tjmMax, function ($query, string $tjmMax) {
                $query->where('tjm', '<=', $tjmMax);
            })
            ->get();
        return response()->json(['data' => $talents, 'status' => 200], 200 );
    }

    /**
     * route : POST /talents
     * Create and store a new talent
     */
    public function create(CreateTalentRequest $request): JsonResponse {
        $talent = new Talent();
        $talent->last       = Str::upper($request->last);
        $talent->first      = Str::headline($request->first);
        $talent->xp         = $request->xp;
        $talent->tjm        = $request->tjm;
        $talent->address    = Str::upper($request->address['address']);
        $talent->complementaddress = Str::upper($request->address['complementaddress']);
        $talent->cp         = $request->address['cp'];
        $talent->city       = Str::upper($request->address['city']);
        $talent->country    = Str::upper($request->address['country']);
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

    /**
     * route : PUT /talents/{$id}/{$field}
     * save a field for a talent
     */
    public function updateField(int $profileId, string $field, Request $request): JsonResponse {
        $talent = Talent::with('skills', 'resumes')->where('id', $profileId)->get()[0];
        switch($talent->$field) {
            case 'last': $talent->$field = strtoupper($request->value); break;
            case 'first': $talent->$field = ucwords($request->value); break;
            default: $talent->$field = $request->value; break;
        }
        $talent->save();
        return response()->json(['data' => $talent, 'status' => 200], 200 );    
    }

    /**
     * route : PUT /talents/{$id}/address
     * save address for a talent
     */
    public function updateAddress(int $profileId, UpdateAddressTalentRequest $request): JsonResponse {
        $talent = Talent::with('skills', 'resumes')->where('id', $profileId)->get()[0];
        $talent->address = Str::upper($request->address);
        $talent->complementaddress = Str::upper($request->complementaddress);
        $talent->cp = $request->cp;
        $talent->city = Str::upper($request->city);
        $talent->country = Str::upper($request->country);
        $talent->save();
        return response()->json(['data' => $talent, 'status' => 200], 200 );    
    }

    /**
     * route : POST /talents/{$id}/skills
     * add a skill for a talent (in skillables table)
     */
    public function addSkill(int $id, Request $request): JsonResponse {
        $talent = Talent::find($id);
        $skillExists = $talent->skills()->where('skill_id', $request->skill_id)->first();
        if($skillExists) {
            return response()->json(['message' => 'Skill already exists for this talent', 'status' => 422], 422 );
        }
        $skill = Skill::find($request->skill_id);
        $talent->skills()->attach($skill);
        return response()->json(['data' =>  $talent->skills , 'status' => 201], 201 ); 
    }

    /**
     * route : DELETE /talents/{$id}/skills/{$skillId}
     * delete a skill for a talent (in skillables table)
     */
    public function deleteSkill(int $id, int $skillId): JsonResponse {
        $talent = Talent::find($id);
        $skillExists = $talent->skills()->where('skill_id', $skillId)->first();
        if(!$skillExists) {
            return response()->json(['message' => 'Skill not found', 'status' => 404], 404 );
        }
        $talent->skills()->detach($skillId);
        return response()->json([
            'id'=> $skillId, 
            'message' => 'Skill removed for this talent', 
            'status' => 200
        ], 200 );
        
    }



    /** RESUMES */

    /**
     * route : POST /talents/{$id}/resumes
     * role  : upload a resume for a talent
     */
    public function uploadResume(int $id, UploadResumeRequest $request, UploadFileManagerService $fileManager) {
        $talent = Talent::find($id);
        if(self::isTalentExists($talent) == false) {
            return response()->json(['status' => 404, 'message'=>'no talent found'], 404 );
        }
        if(count($talent->resumes) >= 3) {
            return response()->json(['status' => 400, 'message'=>'You can not upload more than 3 resumes'], 400);
        }
        $resume = $fileManager->uploadTalentResume($talent, $request->file);
        return response()->json([
            'message' => 'Resume added successfuly',
            'data' => [ 
                'id'            => $resume->id, 
                'file_name'     => $resume->file_name,
                'link'          => '/'. $resume->link, 
                'created_at'    => $resume->created_at 
            ],
            'talent_id' => $id,
            'status' => 201
        ], 201); 
    }

    /**
     * route : GET /talents/{$id}/resumes
     * get all resumes for a talent
     */
    public function getResumeLinks(int $id) {
        $talent = Talent::find($id);
        if(count($talent->resumes) < 1) {
            return response()->json(['data' => null, 'status' => 404, 'message'=>'no resume found for id='. $id], 404 );
        }
        else {
            return response()->json(['data' => $resumes, 'status' => 200], 200 );
        }
    }

    /**
     * route : GET /talents/{$id}/resumes/{$resumeId}
     * download a resume's talent by id
     */
    public function downloadResumeFile(int $id, int $resumeId) {
        $talent = Talent::find($id);
        if(self::isTalentExists($talent) == false) {
            return response()->json(['status' => 404, 'message'=>'no talent found'], 404 );
        }
        $resume = $talent->resumes()->find($resumeId);
        if($resume == null) {
            return response()->json(['status' => 404, 'message'=>'no resume found for id='. $resumeId], 404 );
        }
        return Storage::download($resume->link);
    }

    /**
     * route : DELETE /talents/{$id}/resumes/{$resumeId}
     * delete a resume for a talent
     */
    public function deleteResume(int $id, int $resumeId): JsonResponse {
        $talent = Talent::find($id);
        if(self::isTalentExists($talent) == false) {
            return response()->json(['status' => 404, 'message'=>'no talent found'], 404 );
        }
        $resume = $talent->resumes()->find($resumeId);
        if($resume == null) {
            return response()->json(['status' => 404, 'message'=>'no resume found for id='. $resumeId], 404 );
        }
        $storagelink = $resume->link;
        $isDeletedResume = $resume->delete();
        if($isDeletedResume) {
            Storage::delete ($storagelink);
            return response()->json([
                'message' => 'Resume deleted',
                'id' => $resume->id,
                'status' => 200
            ],200 );
        }
    }

    /** CONTRACTS */

    /**
     * route : GET /talents/{$id}/contracts
     * get all contracts for a talent
     */
    public function getContractLinks(int $id): JsonResponse {
        $talent = Talent::find($id);
        if(count($talent->contracts) > 0) {
            return response()->json(['data' => $contracts, 'status' => 200], 200 );
        }
        else {
            return response()->json(['data' => null, 'status' => 404, 'message'=>'no contract found for id='. $id], 404 );
        }
    }

    /**
     * route : GET /talents/{$id}/contracts/{$contractId}
     * download a contract's talent by id
     */
    public function downloadContractFile(int $id, int $contractId) {
        $talent = Talent::find($id);
        if(self::isTalentExists($talent) == false) {
            return response()->json(['status' => 404, 'message'=>'no talent found'], 404 );
        }
        $contract = $talent->contracts()->find($contractId);
        if($contract == null) {
            return response()->json(['status' => 404, 'message'=>'no contract found for id='. $contractId], 404 );
        }
        return Storage::download($contract->link);
    }

    /**
     * route : DELETE /talents/{$id}/contracts/{$contractId}
     * delete a contract for a talent
     */
    public function deleteContract(int $id, int $contractId): JsonResponse {
        $talent = Talent::find($id);
        if(self::isTalentExists($talent) == false) {
            return response()->json(['status' => 404, 'message'=>'no talent found'], 404 );
        }
        $contract = $talent->contracts()->find($contractId);
        if($contract == null) {
            return response()->json(['status' => 404, 'message'=>'no contract found for id='. $contractId], 404 );
        }
        $storagelink = $contract->link;
        $isDeletedContract = $contract->delete();
        if($isDeletedContract) {
            Storage::delete ($storagelink);
            return response()->json([
                'message' => 'Contract deleted',
                'id' => $contract->id,
                'status' => 200
            ],200 );
        }
    }

    /**
     * route : POST /talents/{$id}/contracts
     * upload a contract for a talent
     */
    public function uploadContract(int $id, Request $request): JsonResponse {
        $talent = Talent::find($id);
        if(self::isTalentExists($talent) == false) {
            return response()->json(['status' => 404, 'message'=>'no talent found'], 404 );
        }
        $contract = $fileManager->uploadTalentContract($talent, $request->file);
        return response()->json([
            'message' => 'Contract added successfuly',
            'data' => [ 
                'id'            => $contract->id, 
                'link'          => '/'. $contract->link, 
                'created_at'    => $contract->created_at 
            ],
            'talent_id' => $id,
            'status' => 201
        ], 201); 
    }





















   

   

    


    // UTILS
    private static function isTalentExists($talent) {
        return ($talent && $talent->last && $talent->first) ? true : false;  
    }


}
