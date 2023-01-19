<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Position;
use App\Models\Api\UserLog;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;
class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Position::with('client')->get();
        return response()->json([ 
            'success'=>'True',
            'message'=>'All Data susccessfull',
            'data'=>$data ]);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
              'position_name' => 'required',
             'client_id' => 'required',
            // 'contact_person' => 'required',
            //  'contact_number' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $program = Position::create([
            'position_name' => $request->position_name,
            'number_opening' => $request->number_opening,
            'salary_range_from' => $request->salary_range_from,
            'salary_range_to' => $request->salary_range_to,
            'descripition' => $request->descripition,
            'client_id' => $request->client_id,
            'client_name' => $request->client_name,           
         ]);
         $user = Auth::guard('api')->user();
         $progra = UserLog::create([
            'action' => 'Create',
            'module' => 'Position',
            'user_id' => $user->id,
            'position_id' => $program->id,


         ]);  
        
         return response()->json([
            'success'=>'True',
            'message'=>'Position created successfully' ,
            'data'=>$program,
            'user'=>$progra,

            ]);    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program = Position::find($id);
        $program->client;
        if (is_null($program)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([
            'success'=>'True' ,
            'data'=>$program
            ]);}

   
     
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'position_name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $program=Position::find($id);
        $program->position_name = $request->position_name;
        $program->number_opening = $request->number_opening;
        $program->salary_range_from = $request->salary_range_from;
        $program->salary_range_to = $request->salary_range_to;
        $program->descripition = $request->descripition;
        $program->client_id = $request->client_id;
        $program->client_name = $request->client_name;
        $program->update();
        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
           'action' => 'Updata',
           'module' => 'Position',
           'user_id' => $user->id,
           'position_id' => $program->id,

        ]);
        
        return response()->json([
            'success'=>'True',
            'message'=>'Position updated successfully.',
            'data'=>$program,
            'user'=>$progra
        ]);    }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $progra = Userlog::create([
            'action' => 'Delete', 
            'module' => 'Position',
            'user_id' => $user->id,
         ]);
        $program=Position::find($id);
       if (!empty($program)) {
        $program->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Position delete successfuly',
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
