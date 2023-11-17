<?php

namespace App\Http\Controllers;
use App\Models\Talent;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TalentController extends Controller
{
    /**
     * route : GET /talents
     * Get all talents
     */
    public function index() {
        $talents = Talent::with('skills', 'resumes')->get();
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
     * search Talents
     * @queryParam skill string (optionnal)
     * @queryParam city string (optionnal)
     * @queryParam tjmMax integer (optionnal)
     * @param Request $request
     * 
     */
    public function search(Request $request) {
        $skill = $request->skill ? strtolower($request->skill) : null;
        $city = $request->city ? strtolower($request->city) : null;
        $tjmMax = $request->tjmMax ?  $request->tjmMax : null;
        $talents = Talent::with('skills')
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

    /**
     * route : POST /talents/{$id}/uploadResume
     * upload a resume for a talent
     * @param int $id (profile id)
     * @param Request $request (file)
     */
    public function uploadResume(int $profileId, Request $request) {
        $talent = Talent::find($profileId);
        if($talent && $talent->last) {
           $lastname = strtolower($talent->last);
           $firstname = $talent->first ? '-'.strtolower($talent->first):'';
           $path = 'profiles/'.$profileId;
           $fileName = 'cv-' . $lastname .  $firstname . '-' . $profileId;
           $extension = $request->file->getClientOriginalExtension();
           Storage::disk('local')->put($path.'/'.$fileName.'.'.$extension, file_get_contents($request->file).$extension);
            $resume = $talent->resumes()->create([
                'link' => '/'.$path.'/'.$fileName.'.'.$extension,
                'talent_id' => $profileId
            ]);
           return '/'.$path.'/'.$fileName.'.'.$extension;
        }
        else {
            return response()->json(['data' => null, 'status' => 404, 'message'=>'no talent found for id='. $id], 404 );
        }
    }

    public function downloadResume(int $profileId, Request $request) {
        $talent = Talent::find($profileId);
        $lastname = strtolower($talent->last);
        $firstname = strtolower($talent->first);
        $filename = 'cv-' .  $lastname .'-'.  $firstname .'-'. $profileId;
        $anonymousFilename = 'cv-'.  $firstname .'-'. $profileId;
        $extension = 'pdf';
        $path = 'profiles/'.$profileId;
        return Storage::download('/'. $path . '/' . $filename . '.' . $extension);
    }

    public function getResumeLinks(int $profileId) {
        $talent = Talent::find($profileId);
        if(count($talent->resumes) > 0) {
            return response()->json(['data' => $resumes, 'status' => 200], 200 );
        }
        else {
            return response()->json(['data' => null, 'status' => 404, 'message'=>'no resume found for id='. $profileId], 404 );
        }
    }

    /**
     * route : PUT /talents/{$id}/{$field}
     * save a field for a talent
     * @param int $id (profile id)
     * @param string $field (field name)
     * @param Request $request (value)
     * @return json
     */
    public function saveField(int $profileId, string $field, Request $request) {
        $talent = Talent::find($profileId);
        $talent->$field = $request->value;
        $talent->save();
        return response()->json(['data' => $talent, 'status' => 200], 200 );    
    }

    /**
     * route : PUT /talents/{$id}/address
     * save address for a talent
     * @param int $id (profile id)
     * @param Request $request (address, complementaddress, cp, city, country)
     * @return json
     */
    public function saveAddress(int $profileId, Request $request) {
        $talent = Talent::find($profileId);
        $talent->address = $request->address;
        $talent->complementaddress = $request->complementaddress;
        $talent->cp = $request->cp;
        $talent->city = $request->city;
        $talent->country = $request->country;
        $talent->save();
        return response()->json(['data' => $talent, 'status' => 200], 200 );    
    }
}
