<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $req){
        $credentials = $req->validate([
            'email'=>['required', 'email'],
            'password'=>'required',
            'remember'=>'boolean',
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if(!Auth::attempt($credentials, $remember)){
            return response([
                'message'=> '帳號或密碼錯誤'
            ], 422);
        }

        $user = Auth::user();
        if(!$user->is_admin){
            Auth::logout();

            return response([
                'message'=>'您沒有權限執行此操作'
            ], 403);
        }

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user'=> new UserResource($user),
            'token'=>$token,
        ]);
    }

    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }

    public function getUser(Request $req){
        return new UserResource($req->user());
    }
}
