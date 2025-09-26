<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required|string|max:100",
            "email" => "required|string|email|max:100|unique:users,email",
            "password" => "required|string|min:8|confirmed",
        ]);


        if($validator->fails()){
            // return response()->json($validator->errors(),422);
            return response()->json($validator->errors());
        }

        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=> Hash::make($request->password)
            // "password"=>bcrypt($request->password)
        ]);
        // $token = $user->createToken("API Token")->accessToken;

        return response()->json([
            "message"=>"User registered successfully."
            // "token"=>$token
        ],200);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required|string",
            "password" => "required|string",
        ]);


        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $user = User::where('email',$request->email)
        ->orWhere("employee_id",$request->email)
        ->first();

        if(!$user || !Hash::check($request["password"],$user->password)){
            return response()->json(["message"=>"Invalid credentials"],401);
        }

        // Generate token
        $createtoken = $user->createToken("Personal Access Token");
        $token = $createtoken->accessToken;

        return response()->json([
            "token"=>$token,
            "token_type"=>"Bearer",
            "user"=> $user
        ],200);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json(["message"=>"Logged out successfully"]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
