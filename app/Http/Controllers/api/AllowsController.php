<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Api\Allow;
use App\Models\Api\Resume;
use App\Models\Api\Status;
use App\Models\Api\UserLog;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;


class AllowsController extends Controller
{

    public function index()
    {
        $data = Allow::latest()->with('user', 'client', 'position')->get();
        if (is_null($data)) {
            return response()->json('data not found',);
        }
        return response()->json([
            'success' => 'True',
            'message' => 'All Data susccessfull',
            'data' => $data,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //   'name' => 'required',
            //  'email' => 'required',
            // 'contact_person' => 'required',
            //  'contact_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $program = Allow::create([
            'user_allow' => $request->user_allow,
            'user_id' => $request->user_id,
            'position_id' => $request->position_id,
            'client_id' => $request->client_id,


        ]);
        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
            'action' => 'Create',
            'module' => 'AssignPosition',
            'user_id' => $user->id,
            'assignPosition_id' => $program->id,

        ]);
        if (is_null($program)) {
            return response()->json('storage error',);
        }
        return response()->json([
            'success' => 'True',
            'message' => 'created successfully',
            'data' => $program,
            'user' => $progra,
        ]);
    }

    public function show($id)
    {
        $program = Allow::find($id);
        $program->client;
        $program->user;
        $program->position;
        if (is_null($program)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([
            'success' => 'True',
            'data' => $program,
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $program = Allow::find($id);
        $program->user_allow = $request->user_allow;
        $program->user_id = $request->user_id;
        $program->client_id = $request->client_id;
        $program->position_id = $request->position_id;

        $program->update();
        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
            'action' => 'Updata',
            'module' => 'AssignPosition',
            'user_id' => $user->id,
            'assignPosition_id' => $program->id,
            'update_value' => $progra=$request->update_value,


        ]);
        return response()->json([
            'success' => 'True',
            'message' => 'client updated successfully.',
            'data' => $program,
            'user' => $progra
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $progra = Userlog::create([
            'action' => 'Delete',
            'module' => 'AssignPosition',
            'assignPosition_id' => $user->id,
        ]);
        $program = Allow::find($id);
        if (!empty($program)) {
            $program->delete();
            return response()->json([
                'success' => true,
                'message' => ' delete successfuly',
                'user' => $progra
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something wrong try again ',
            ]);
        }
    }


    public function userAlow()
    {
        $user = Auth::guard('api')->user();
        $userAllow = Allow::with('user', 'client', 'position')->whereIn('user_id', $user)->get();
        if (is_null($userAllow)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([
            'success' => 'True',
            'data' => $userAllow,
        ]);
    }


    public function dashboradData()
    {  
        $user = Auth::user();
        if($user->role_id === 1){
            $userAllow = Allow::with('user', 'client', 'position')->get() ;
            $userAllows = Resume::with('position')->select('position_id')->get();
            if (is_null($userAllow)) {
                return response()->json('Data not found', 404);
            }
            return response()->json([
                'success' => 'True',
                'data' => $userAllow,
                'resume' => $userAllows
            ]);
        }else{
            $userAllow = Allow::with('user', 'client', 'position')->whereIn('user_id', $user)->get() ;
            $userAllows = Resume::with('position')->select('position_id')->whereIn('user_id', $user)->get();
            if (is_null($userAllow)) {
                return response()->json('Data not found', 404);
            }
            return response()->json([
                'success' => 'True',
                'data' => $userAllow,
                'resume' => $userAllows
            ]);
        }
       
    }
}
