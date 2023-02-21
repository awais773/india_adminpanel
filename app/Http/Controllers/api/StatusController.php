<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Status;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;
use App\Models\Api\UserLog;
use Illuminate\Support\Facades\Auth;


class StatusController extends Controller
{

    public function index()
    {
        $data = Status::latest()->get();
        if (is_null($data)) {
            return response()->json('data not found', ); 
        } 
        return response()->json([ 
        'success'=>'True',
        'message'=>'All Data susccessfull',
        'data'=>$data, ]);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            //   'name' => 'required',
            //  'email' => 'required',
            // 'contact_person' => 'required',
            //  'contact_number' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $program = Status::create([
            'status_name' => $request->status_name,

         ]);  
         $user = Auth::guard('api')->user();
         $progra = UserLog::create([
            'action' => 'Create',
            'module' => 'Status',
            'user_id' => $user->id,
            'status_id' => $program->id,

         ]);
         if (is_null($program)) {
            return response()->json('storage error', ); 
        } 
        return response()->json([
            'success'=>'True',
            'message'=>'Client created successfully',
            'data'=>$program,
            'user'=>$progra,
            ]);
    }

    public function show($id)
    {
        $program = Status::find($id);
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
        $program=Status::find($id);
        $program->status_name = $request->status_name;
        $program->update();
        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
           'action' => 'Updata',
           'module' => 'Status',
           'user_id' => $user->id,
           'status_id' => $program->id,
           'update_value' => $progra=$request->update_value,


        ]);
        return response()->json([
            'success'=>'True',
             'message'=>'client updated successfully.',
             'data'=>$program,
            'user'=>$progra]);
    }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $progra = Userlog::create([
            'action' => 'Delete', 
            'module' => 'Status',
            'user_id' => $user->id,
         ]);
        $program=Status::find($id);
       if (!empty($program)) {
        $program->delete();
        return response()->json([
            'success'=>true,
            'message'=>' delete successfuly',
            'user'=>$progra
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