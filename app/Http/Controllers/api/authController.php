<?php

namespace App\Http\Controllers\api;

use ZipArchive;
use App\Models\User;
use App\Models\Api\Role;
use App\Models\Api\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('Token')->accessToken;
        return response()->json([
            'success' => 'True',
            'message' => 'register successfull',
            'token' => $token, 'user' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data) && Auth::check() && Auth::user()->block != null) {
            return response()->json([
                'message' => false,
                'error' => 'user Block'
            ], 401);
        } else(auth()->attempt($data)); {
            if (auth()->attempt($data)) {
                $token = auth()->user()->createToken('Token')->accessToken;
                return response()->json([
                    'success' => 'True',
                    'message' => 'login successfull',
                    'user' => User::with('role')->find(Auth::id()),
                    'token' => $token,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Falls',
                    'error' => 'please register'
                ], 401);
            }
        }

        
            
        
    }

    public function userinfo()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }

    public function zip($images)
    {
        $images = explode(',', $images);
        $zipFileName = 'files.zip';
        
        $zip = new ZipArchive;
        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        foreach ($images as $image) {
            $imagePath = public_path("file/{$image}");
            if (file_exists($imagePath)) {
                $zip->addFile($imagePath, $image);
            }
        }
        
        $zip->close();
        
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }


//   

}