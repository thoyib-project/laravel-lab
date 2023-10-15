<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $req) 
    {
        // $req->validate();
        // $user = User::created([
        //     "name" => $req->name,
        //     "email" => $req->email,
        //     "password" => Hash::make($req->password),
        // ]);
        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
        ]);
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()->first()], 422);
        throw new ValidationException($validator, $response);
        // throw new HttpResponseException($validator, $response);
    }


    public function login(Request $request)
    {
        // dump('masuk sini coy');
        if (!Auth::attempt($request->only("email", "password"))) {
            return response()->json(
                [
                    "message" => "Invalid login details",
                ],
                401
            );
        }

        $user = User::where("email", $request["email"])->firstOrFail();

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }
}
