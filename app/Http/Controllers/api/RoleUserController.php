<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Hash;


class RoleUserController extends Controller
{

    public function index()
    {
        $data = User::with('role')->get();
        if (is_null($data)) {
            return response()->json('data not found', ); 
        } 
        return response()->json([ 
        'success'=>'True',
        'message'=>'All Data susccessfull',
        'data'=>$data,
         $data[0]->role ]);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            //   'name' => 'required',
             'email' => 'required',
            // 'contact_person' => 'required',
            //  'contact_number' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

    {
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'role_id'=> $request->role_id,
            'password'=> Hash::make($request->password)         
        ]);
       $token = $user->createToken('Token')->accessToken;
       return response()->json([
        'success'=>'True',
        'message'=>'User Create successfull',
        'token'=>$token,'user'=>$user],200);
    }
    }

    public function show($id)
    {
        $program = User::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([
            'success'=>'True' ,
            'data'=>$program,
            ]);
    }

   
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            // 'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $program=User::find($id);
        $program->name = $request->name;
        $program->email = $request->email;
        $program->role_id = $request->role_id;
        $program->password = $request->password;
        $program->update();
        return response()->json([
            'success'=>'True',
             'message'=>'User updated successfully.',
             'data'=>$program]);
    }

    public function destroy($id)
    {
        $program=User::find($id);
       if (!empty($program)) {
        $program->delete();
        return response()->json([
            'success'=>true,
            'message'=>' delete successfuly',
        ],200);
    }
    else {
        return response()->json([
            'success'=>false,
            'message'=>'something wrong try again ',
        ]);
    }
       
    }
}