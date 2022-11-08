<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\ClientCommercial;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;

class ClientCommercialController extends Controller
{

    public function index()
    {
        $data = ClientCommercial::with('currency')->get();
        if (is_null($data)) {
            return response()->json('data not found', ); 

        } 
            return response()->json([ 
                'success'=>'True',
                'message'=>'All Data susccessfull',
                'data'=>$data,
                 $data[0]->currency ]);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            //   'name' => 'required',
            //  'email' => 'required',
            'form' => 'required',
            // 'contact_person' => 'required',
            //  'contact_number' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $program = ClientCommercial::create([
            'form' => $request->form,
            'to' => $request->to,
            'percentage' => $request->percentage,
            'currency_id' => $request->currency_id,
            'client_id' => $request->client_id,
         ]);  
         if (is_null($program)) {
            return response()->json('storage error', ); 
        } 
        return response()->json([
            'success'=>'True',
            'message'=>'Client created successfully',
            'data'=>$program,
            ]);
    }

    public function show($id)
    {
        $program = ClientCommercial::find($id);
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
        $program=ClientCommercial::find($id);
        $program->form = $request->form;
        $program->to = $request->to;
        $program->percentage = $request->percentage;
        $program->currency_id = $request->currency_id;
        $program->client_id = $request->client_id;
        $program->update();
        return response()->json([
            'success'=>'True',
             'message'=>'client updated successfully.',
             'data'=>$program]);
    }

    public function destroy($id)
    {
        $program=ClientCommercial::find($id);
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