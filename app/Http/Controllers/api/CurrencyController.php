<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Currency;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;
class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Currency::latest()->get();
        return response()->json([($data), 'All Data susccessfull.']);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
              'currency_name' => 'required',
            //  'email' => 'required',
            // 'contact_person' => 'required',
            //  'contact_number' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $program = Currency::create([
            'currency_name' => $request->currency_name,
            'client_id' => $request->client_id,
            'position_id' => $request->position_id,           
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
        $program = Currency::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([($program)]);
    }

   
     
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            // 'currency_name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $program=Currency::find($id);
        $program->currency_name = $request->currency_name;
        $program->client_id = $request->client_id;
        $program->position_id = $request->position_id;
        $program->update();
        
        return response()->json(['Program updated successfully.',($program)]);
    }

    public function destroy($id)
    {
        $program=Currency::find($id);
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
