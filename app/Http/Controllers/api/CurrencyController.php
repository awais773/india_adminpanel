<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Position;
use App\Models\Api\Client;
use App\Models\Api\Currency;
use App\Models\Api\UserLog;
use Illuminate\Support\Facades\Auth;
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
            //   'position_id' => 'required',
            //   'client_id' => 'required',
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
         $user = Auth::guard('api')->user();
         $progra = UserLog::create([
            'action' => 'Create',
            'module' => 'Currency',
            'user_id' => $user->id,
            'currency_id' => $program->id,
            

         ]);  
        
         return response()->json([
            'success'=>'True',
            'message'=>'Currency created successfully' ,
            'data'=>$program,
            'user'=>$progra,
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

        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
           'action' => 'Updata',
           'module' => 'currency',
           'user_id' => $user->id,
           'currency_id' => $program->id,
           'update_value' => $progra=$request->update_value,


        ]);
        return response()->json([
            'success'=>'True',
             'message'=>'Currency updated successfully.',
             'data'=>$program,
             'user'=>$progra,

             ]);    }

    public function destroy(Request $request ,$id)
    {
        $user = Auth::guard('api')->user();
        $progra = Userlog::create([
            'action' => 'Delete', 
            'module' => 'Currency',
            'user_id' => $user->id,
         ]);
        $program=Currency::find($id);
       if (!empty($program)) {
        $program->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Currency delete successfuly',
            'user'=> $progra
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
