<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Api\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductResource;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;

class clientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Client::latest()->get();
        return response()->json([($data), 'All Data susccessfull.']);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
              'name' => 'required',
            //  'email' => 'required',
            // 'contact_person' => 'required',
            //  'contact_number' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $program = Client::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'address' => $request->address,
            'end_date' => $request->end_date,
            'start_date' => $request->start_date,
            'path' => $request->path,
            'agreementfile' => $request->agreementfile,


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
        $program = Client::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([($program)]);
    }

   
     
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $program=Client::find($id);
        $program->name = $request->name;
        $program->contact_person = $request->contact_person;
        $program->contact_number = $request->contact_number;
        $program->email = $request->email;
        $program->city = $request->city;
        $program->state = $request->state;
        $program->pincode = $request->pincode;
        $program->address = $request->address;
        $program->end_date = $request->end_date;
        $program->start_date = $request->start_date;
        $program->path = $request->path;
        $program->agreementfile = $request->agreementfile;
        $program->update();
        
        return response()->json(['Program updated successfully.',($program)]);
    }

    public function destroy($id)
    {
        $program=Client::find($id);
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