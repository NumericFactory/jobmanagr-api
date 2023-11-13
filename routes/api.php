<?php

use Illuminate\Http\Request;
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

Route::get('/jobs', [\App\Http\Controllers\JobController::class, 'index']);
Route::get('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'find']);
Route::post('/jobs', [\App\Http\Controllers\JobController::class, 'create']);
Route::put('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'update']);
Route::patch('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'patch']);
Route::delete('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'delete']);

Route::get('/talents', [\App\Http\Controllers\TalentController::class, 'index']);
Route::get('/talents/{id}', [\App\Http\Controllers\TalentController::class, 'find']);
Route::post('/talents', [\App\Http\Controllers\TalentController::class, 'create']);
Route::put('/talents/{id}', [\App\Http\Controllers\TalentController::class, 'update']);
Route::patch('/talents/{id}', [\App\Http\Controllers\TalentController::class, 'patch']);
Route::delete('/talents/{id}', [\App\Http\Controllers\TalentController::class, 'delete']);
Route::get('/talents/search/{skillid}', [\App\Http\Controllers\TalentController::class, 'searchBySkills']);

Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index']);
Route::get('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'find']);
Route::post('/customers', [\App\Http\Controllers\CustomerController::class, 'create']);
Route::put('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'update']);
Route::patch('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'patch']);
Route::delete('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'delete']);

Route::get('/contacts', [\App\Http\Controllers\ContactController::class, 'index']);
Route::post('/contacts', [\App\Http\Controllers\ContactController::class, 'create']);
Route::put('/contacts/{id}', [\App\Http\Controllers\ContactController::class, 'update']);
Route::patch('/contacts/{id}', [\App\Http\Controllers\ContactController::class, 'patch']);
Route::delete('/contacts/{id}', [\App\Http\Controllers\ContactController::class, 'delete']);

Route::get('/skills', [\App\Http\Controllers\SkillController::class, 'index']);
Route::post('/skills', [\App\Http\Controllers\SkillController::class, 'create']);
Route::put('/skills/{id}', [\App\Http\Controllers\SkillController::class, 'update']);
Route::patch('/skills/{id}', [\App\Http\Controllers\SkillController::class, 'patch']);
Route::delete('/skills/{id}', [\App\Http\Controllers\SkillController::class, 'delete']);