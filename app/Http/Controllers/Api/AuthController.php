<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function validateToken(Request $request)
    {
        // Vérifie si l'utilisateur est authentifié
        if (Auth::check()) {
            return response()->json(['valid' => true], 200);
        } else {
            return response()->json(['valid' => false, 'message' => 'Token expiré ou invalide'], 401);
        }
    }

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

    public function register(Request $request)
    {
        $attrs = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $attrs['password'] = Hash::make($attrs['password']);

        event(new Registered($user = User::create($attrs)));

        Auth::login($user);

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
