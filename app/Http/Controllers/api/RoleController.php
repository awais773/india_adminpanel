<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Role;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;

class RoleController extends Controller
{
    public function index()
    {
        $data = Role::latest()->get();
        return response()->json([($data), 'All Data susccessfull.']);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
              'role_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $program = Role::create([
            'role_name' => $request->role_name,
        'privileges_type' => $request->privileges_type,
                     
         ]);
        
        return response()->json(['Program created successfully.',($program)]);
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
        return response()->json([($program)]);
    }

   
     
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'role_name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $program=Role::find($id);
        $program->role_name = $request->role_name;
        $program->update();
        
        return response()->json(['Program updated successfully.',($program)]);
    }

    public function destroy($id)
    {
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

