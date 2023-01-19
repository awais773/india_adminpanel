<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Role;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;
use App\Models\Api\UserLog;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{
    public function index()
    {
        $data = Role::latest()->get();
        return response()->json([ 
            'success'=>'True',
            'message'=>'All Data susccessfull',
            'data'=>$data ]);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            //   'role_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $program = Role::create([
         'role_name' => $request->role_name,
        'privileges_type' => $request->privileges_type,
                     
         ]);
         $user = Auth::guard('api')->user();
         $userlog = UserLog::create([
            'action' => 'Create',
            'module' => 'Role',
            'user_id' => $user->id,
            'role_id' => $program->id,

         ]);  
        
         return response()->json([
            'success'=>'True',
            'message'=>'Role created successfully' ,
            'data'=>$program,
            'user'=> $userlog]);     
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program = Role::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([
            'success'=>'True',
            'data'=>$program,
            ]);    
        }

   
     
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            // 'role_name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $program=Role::find($id);
        if (!empty($request->input('role_name'))) {
            $program->role_name = $request->input('role_name');
        }
        if(!empty($request->input('privileges_type'))) {
            $program->privileges_type = $request->input('privileges_type');
        }
        $program->update();

        $user = Auth::guard('api')->user();
        $userlog = UserLog::create([
           'action' => 'Update',
           'module' => 'Role',
           'user_id' => $user->id,
           'role_id' => $program->id,

        ]);  
        
        return response()->json([
            'success'=>'True',
             'message'=>'Role updated successfully.',
             'data'=>$program,
             'user'=>$userlog
             ]);     }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $progra = Userlog::create([
            'action' => 'Delete', 
            'module' => 'Role',
            'user_id' => $user->id,
         ]);
        $program=Role::find($id);
       if (!empty($program)) {
        $program->delete();
        return response()->json([
            'success'=>true,
            'message'=>'User delete successfuly',
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

