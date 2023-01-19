<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Api\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)         
        ]);
       $token = $user->createToken('Token')->accessToken;
       return response()->json([
        'success'=>'True',
        'message'=>'register successfull',
        'token'=>$token,'user'=>$user,],200);
    }

    public function login(Request $request)
    {
        $data=[
            'email'=>$request->email,
            'password'=>$request->password
        ];

          if(auth()->attempt($data))
          {
             $token = auth()->user()->createToken('Token')->accessToken;
             return response()->json([
                'success'=>'True',
                'message'=>'login successfull',
                'user'=> User::with('role')->find(Auth::id()),
                'token'=>$token,
                 ],200);
          } 
          else{
            return response()->json([
                'message'=>'Falls',
                'error'=>'please register'],401);
          }
    }

    public function userinfo()
    {
        $user = auth()->user();
        return response()->json(['user'=>$user],200);      

    }
}
