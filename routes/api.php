<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use Auth0\Laravel\Facade\Auth0;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::get('/', function () {
    if (! auth()->check()) {
      return response()->json([
        'message' => 'You did not provide a valid token.',
      ]);
    }
  
    return response()->json([
        'message' => 'Your token is valid; you are authorized.',
        'id' => auth()->id(),
        'token' => auth()?->user()?->getAttributes(),
            ]);
    });

    Route::get('/private', function () {
        return response()->json([
        'message' => 'Your token is valid; you are authorized.',
        ]);
    })->middleware('auth');

    Route::get('/scope', function () {
    return response()->json([
      'message' => 'Your token is valid and has the `read:messages` permission; you are authorized.',
    ]);
})->middleware('auth')->can('read:messages');


Route::get('/me', function () {
    if (! auth()->check()) {
      return response()->json([
        'message' => 'You did not provide a valid token.',
      ]);
    }
    $user = auth()->id();
    $profile = cache()->get($user);
  
    if (null === $profile) {
      $endpoint = Auth0::management()->users();
      $profile = $endpoint->get($user);
      $profile = Auth0::json($profile);
  
      cache()->put($user, $profile, 120);
    }
  
    $name = $profile['name'] ?? 'Unknown';
    $email = $profile['email'] ?? 'Unknown';
  
    return response()->json([
      'name' => $name,
      'email' => $email,
    ]);
  });
  //->middleware('auth');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/', function () {return "Hello I am JobBoard API!";});

Route::get('/logout', [LogoutController::class, 'invoke'])
    ->middleware(['auth', 'auth.session']);
Route::get('/login', function () {return "Hello I am JobBoard API!";});

// jobs
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'find']);
Route::post('/jobs', [JobController::class, 'create']);
Route::put('/jobs/{id}', [JobController::class, 'update']);
Route::patch('/jobs/{id}', [JobController::class, 'patch']);
Route::delete('/jobs/{id}', [JobController::class, 'delete']);

// talents
Route::get('/talents', [TalentController::class, 'index']);
Route::get('/talents/search', [TalentController::class, 'search']);
Route::get('/talents/{id}', [TalentController::class, 'find']);
Route::post('/talents', [TalentController::class, 'create']);
Route::put('/talents/{id}', [TalentController::class, 'update']);
Route::patch('/talents/{id}', [TalentController::class, 'patch']);
Route::delete('/talents/{id}', [TalentController::class, 'delete']);
Route::post('/talents/{id}/skills', [TalentController::class, 'addSkill']);
Route::delete('/talents/{id}/skills/{skillId}', [TalentController::class, 'deleteSkill']);
Route::put('/talents/{id}/address', [TalentController::class, 'updateAddress']);
Route::put('/talents/{id}/{field}', [TalentController::class, 'updateField']);

Route::get('/talents/{id}/resumes', [TalentController::class, 'getResumeLinks']);
Route::post('/talents/{id}/resumes', [TalentController::class, 'uploadResume']);
Route::get('/talents/{id}/resumes/{resumeId}', [TalentController::class, 'downloadResumeFile']);
Route::delete('/talents/{id}/resumes/{resumeId}', [TalentController::class, 'deleteResume']);

Route::get('/talents/{id}/contracts', [TalentController::class, 'getContractsLinks']);
Route::post('/talents/{id}/contracts', [TalentController::class, 'uploadContract']);
Route::get('/talents/{id}/contracts/{contractId}', [TalentController::class, 'downloadContractFile']);
Route::delete('/talents/{id}/contracts/{contractId}', [TalentController::class, 'deleteContract']);

// customers
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'find']);
Route::post('/customers', [CustomerController::class, 'create']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::patch('/customers/{id}', [CustomerController::class, 'patch']);
Route::delete('/customers/{id}', [CustomerController::class, 'delete']);

// contacts
Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'create']);
Route::put('/contacts/{id}', [ContactController::class, 'update']);
Route::patch('/contacts/{id}', [ContactController::class, 'patch']);
Route::delete('/contacts/{id}', [ContactController::class, 'delete']);

// skills
Route::get('/skills', [SkillController::class, 'index']);
Route::post('/skills', [SkillController::class, 'create']);
Route::put('/skills/{id}', [SkillController::class, 'update']);
Route::patch('/skills/{id}', [SkillController::class, 'patch']);
Route::delete('/skills/{id}', [SkillController::class, 'delete']);