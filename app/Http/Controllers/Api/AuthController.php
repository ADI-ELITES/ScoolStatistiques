<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    //  Authentification d'un user
    public function login(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($attrs)) {
            return response(['message' => 'Invalid credentials.'], 403);
        }

        //  return user & token in response
        return response()->json([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ]);
    }


    //  Logout d'un user
    public function logout()
    {

        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Déconnexion réussit!'
        ], 200);
    }


    //  Information d'un utilisateur
    public function user()
    {
        return response(['user' => auth()->user()], 200);
    }
}
