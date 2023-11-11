<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
