<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Position;
use App\Models\Api\Client;
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
            'symbol' => $request->symbol,
            'client_id' => $request->client_id,
            'position_id' => $request->position_id,           
         ]);
        
         return response()->json([
            'success'=>'True',
            'message'=>'Currency created successfully' ,
            'data'=>$program,
            ]);    
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
        return response()->json([
            'success'=>'True'  ,
            'data'=>$program,
            ]);   
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
        $program->symbol = $request->symbol;
        $program->client_id = $request->client_id;
        $program->position_id = $request->position_id;
        $program->update();
        
        return response()->json([
            'success'=>'True',
             'message'=>'Currency updated successfully.',
             'data'=>$program,
             ]);    }

    public function destroy($id)
    {
        $program=Currency::find($id);
       if (!empty($program)) {
        $program->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Currency delete successfuly',
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
