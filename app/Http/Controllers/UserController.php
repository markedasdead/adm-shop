<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $registrationValidator = validator($request->all(), [
           "email" => "required|email|unique:users",
           "password" => [
               "required",
               "min:5",
               "regex:/^[A-Za-z#_\-\$]+$/",
               "regex:/[A-Z]{1}/",
               "regex:/[a-z]{1}/",
               "regex:/[#_\-\$]{1}/",
           ]
        ]);

        if($registrationValidator->fails()) return $this->errors(errors: $registrationValidator->errors());

        User::create($registrationValidator->validated());

        return response()->json([
           "success" => true
        ], 201);
    }

    public function authenticate(Request $request)
    {
        $credentialsValidator = validator($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        if($credentialsValidator->fails()) return $this->errors(errors: $credentialsValidator->errors());

        if(!auth()->attempt($credentialsValidator->validated())) return $this->errors(message: "Invalid data", errors: ["email" => ["Invalid data"]]);

        $authenticatedUser = auth()->user();
        $apiToken = Str::uuid();
        $authenticatedUser->update(["token" => $apiToken]);

        return response()->json([
           "token" => $apiToken
        ]);
    }
}
