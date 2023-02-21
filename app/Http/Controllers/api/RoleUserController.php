<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Api\UserLog;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;


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
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    
        if($validator->fails()){
                return response()->json([
                    'success'=>false,
                    // 'message' => $validator->errors()->toJson()
                     'message'=> 'Email already exist',
        
                ], 400);
        }

    {
        $roleUsers = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'role_id'=> $request->role_id,
            'block'=> $request->block,
            'password'=> Hash::make($request->password)         
        ]);
        $user = Auth::guard('api')->user();
        $userlog = UserLog::create([
           'action' => 'Create',
           'module' => 'User',
           'users_id' => $roleUsers->id,
           'user_id' =>  $user->id,
        ]);  


       $token = $user->createToken('Token')->accessToken;
       return response()->json([
        'success'=>'True',
        'message'=>'User Create successfull',
        'token'=>$token,
        'user'=>$roleUsers,
        'userLog'=>$userlog

    ],200);
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
        $program->block = $request->block;
        $program->password = Hash::make($request->password);       
        $program->update();

        $user = Auth::guard('api')->user();
        $userlog = UserLog::create([
           'action' => 'Update',
           'module' => 'User',
           'users_id' => $program->id,
           'user_id' =>  $user->id,
           'update_value' => $progra=$request->update_value,

        ]);  
        return response()->json([
            'success'=>'True',
             'message'=>'User updated successfully.',
            'data'=>$program,
            'userLog'=>$userlog
            ]);
    }

    public function destroy($id)
    {
        $program=User::find($id);
       if (!empty($program)) {
        $program->delete();
        return response()->json([
            'success'=>'True',
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
    public function getUserLogs($id)
    {
        $program = UserLog::find($id);
        $program ->user;
        $program ->client;
        $program ->status;
        $program ->resume;
        $program ->currency;
        $program ->role;
        $program ->position;
        $program ->state;
        $program ->city;
        $program ->assignPosition;

        if (is_null($program)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([
            'success'=>'True' ,
            'data'=>$program,
            ]);
    }

    
    public function allLogs(Request $request)
    {
        $serchData = $request->module;

        $data = UserLog::latest()->with('user','client','status','resume','currency','role','position','city','state','assignPosition')->where('module','LIKE',"%{$serchData}%")->get();
        if (is_null($data)) {
            return response()->json('data not found', ); 
        } 
        return response()->json([ 
        'success'=>'True',
        'message'=>'All Data susccessfull',
        'data'=>$data,

    ]);
    
       
    }
}