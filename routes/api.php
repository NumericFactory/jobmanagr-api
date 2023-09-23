<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/jobs', [\App\Http\Controllers\JobController::class, 'index']);
Route::post('/jobs', [\App\Http\Controllers\JobController::class, 'create']);
Route::put('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'update']);
Route::patch('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'patch']);
Route::delete('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'delete']);

Route::get('/talents', [\App\Http\Controllers\TalentController::class, 'index']);
Route::post('/talents', [\App\Http\Controllers\TalentController::class, 'create']);
Route::put('/talents/{id}', [\App\Http\Controllers\TalentController::class, 'update']);
Route::patch('/talents/{id}', [\App\Http\Controllers\TalentController::class, 'patch']);
Route::delete('/talents/{id}', [\App\Http\Controllers\TalentController::class, 'delete']);

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