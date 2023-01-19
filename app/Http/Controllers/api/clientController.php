<?php

namespace App\Http\Controllers\API;

use App\Models\Api\Client;
use App\Models\Api\UserLog;
use App\Models\Api\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GrahamCampbell\ResultType\Success;
use App\Http\Resources\ProductResource;
use App\Models\Api\City;
use App\Models\Api\Position;
use App\Models\Api\Resume;
use App\Models\Api\State;
use App\Models\Api\Status;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public function index()
    {
        $data = Client::latest()->get();
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
            'commercials_type' => $request->commercials_type,
            'postion_allows' => $request->postion_allows,
            'document' => $request->document,


        ]);
        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
            'action' => 'Create',
            'module' => 'Client',
            'user_id' => $user->id,
            'client_id' => $program->id,

        ]);

        if (is_null($program)) {
            return response()->json('storage error',);
        }
        return response()->json([
            'success' => 'True',
            'message' => 'Client created successfully',
            'data' => $program,
            'userlog' => $progra

        ]);
    }

    public function show($id)
    {
        $program = Client::find($id);
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
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $program = Client::find($id);
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
        $program->commercials_type = $request->commercials_type;
        $program->position_allows = $request->position_allows;
        $program->document = $request->document;

        $program->update();
        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
            'action' => 'Updata',
            'module' => 'client',
            'user_id' => $user->id,
            'client_id' => $program->id,


        ]);
        return response()->json([
            'success' => 'True',
            'message' => 'client updated successfully.',
            'data' => $program,
            'user' => $progra,

        ]);
    }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $progra = Userlog::create([
            'action' => 'delete',
            'module' => 'client',
            'user_id' => $user->id,
        ]);
        $program = Client::find($id);
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

    public function documents(Request $req){

           $blog = new Document();
        if ($image = $req->file('file')) {
            $destinationPath = 'file/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
            $blog->path = $profileImage;
        }
            $blog->save();
            return response()->json([
                'success' => 'True',
                'message' => 'File Create successfully.',
                'data' => $blog ,
    
            ]);
    }

    public function destroyDocument($id)
    {
        $program = Document::find($id);
        if (!empty($program)) {
            $program->delete();
            return response()->json([
                'success' => 'True',
                'message' => ' delete successfuly',
            ], 200);
        } else {
            return response()->json([
                'success' => 'False',
                'message' => 'something wrong try again ',
            ]);
        }
    }


    public function totalData()
    {
        $program = Client::count();
        $position = Position::count();
        $user = Auth::guard('api')->user();
        $resume = Resume::whereIn('user_id', $user)->get(); 


        if (is_null($program)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([
            'success' => 'True',
            'message' => 'all data sucessfull',
            'data'=> $data = ([
            'client' => $program,
            'position' => $position,
            'resume' => $resume,
            ]),

        ]);
    }

    public function resumeDependencies()
    {
        $client = Client::get();
        $position = Position::get();
        $status = Status::latest()->get();
        $city = City::latest()->get(); 
        $state = State::latest()->get(); 

        $data =[ 'position'=>$position , 'status'=>$status , 'city'=>$city, 'state'=>$state,'client'=>$client] ;
        return response()->json([
            'success' => 'True',
            'message' => 'all data sucessfull',
            'resumeDependencies'=> $data 
        ]);
    }
}
