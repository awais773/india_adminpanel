<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Api\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductResource;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;
use App\Models\Api\Position;
use App\Models\Api\Client;
use App\Models\Api\Currency;
use App\Models\Api\Status;
use App\Models\Api\ClientCommercial;
use App\Models\Api\ResumeLog;
use App\Models\Api\UserLog;
use Illuminate\Support\Facades\Auth;
use App\Models\User;




class ResumeController extends Controller
{

    public function index()
    {
        $data = Resume::with('status','position','city','state','currentCity','expectedCity' )->get();
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
            //   'status_id' => 'required',
            //  'email' => 'required',
            // 'contact_person' => 'required',
            //  'contact_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = Auth::guard('api')->user();
        $program = Resume::create([
            'sr_no' => $request->sr_no,
            'country' => $request->country,
            'client' => $request->client,
            'requirement' => $request->requirement,
            'cv_shared_date' => $request->cv_shared_date,
            'candidate_name' => $request->candidate_name,
            'contact_no' => $request->contact_no,
            'email_id' => $request->email_id,
            'current_location' => $request->current_location,
            'highest_qualification' => $request->highest_qualification,
            'current_organisation' => $request->current_organisation,
            'current_designation' => $request->current_designation,
            'exp_in_yrs' => $request->exp_in_yrs,
            'current_city' => $request->current_city,
            'variable' => $request->variable,
            'expected_city' => $request->expected_city,
            'notice_period' => $request->notice_period,
            'feedback' => $request->feedback,
            'candidate_status' => $request->candidate_status,
            'date' => $request->date,
            'status_id' => $request->status_id,
            'position_id' => $request->position_id,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'user_id' =>  $user->id,

        ]);
        $user = Auth::guard('api')->user();
        $progra = Resumelog::create([
            'type' => 'create',
            'resume_id' => $program->id,
            'status_id' => $program->status_id,
            'user_id' =>  $user->id,
        ]); 
        $user = Auth::guard('api')->user();
        $userlog = UserLog::create([
            'action' => 'Create',
            'module' => 'Resume',
            'user_id' => $user->id,
            'resume_id' => $program->id,


        ]);
        if (is_null($program)) {
            return response()->json('storage error',);
        }
        return response()->json([
            'success' => 'True',
            'message' => 'Resume created successfully',
            'data' => $program,
            'log data' => $progra,
            'user' => $userlog,

        ]);
    }

    public function show($id)
    {
        $program = Resume::find($id);
        $program->status;
        $program->position;
        $program->city;
        $program->state;
        $program->expectedCity;
        $program->currentCity;

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
            // 'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = Auth::guard('api')->user();
        $program = Resume::find($id);
        $program->sr_no = $request->sr_no;
        $program->country = $request->country;
        $program->client = $request->client;
        $program->requirement = $request->requirement;
        $program->cv_shared_date = $request->cv_shared_date;
        $program->candidate_name = $request->candidate_name;
        $program->contact_no = $request->contact_no;
        $program->email_id = $request->email_id;
        $program->current_location = $request->current_location;
        $program->highest_qualification = $request->highest_qualification;
        $program->current_organisation = $request->current_organisation;
        $program->current_designation = $request->current_designation;
        $program->exp_in_yrs = $request->exp_in_yrs;
        $program->current_city = $request->current_city;
        $program->variable = $request->variable;
        $program->expected_city = $request->expected_city;
        $program->notice_period = $request->notice_period;
        $program->feedback = $request->feedback;
        $program->candidate_status = $request->candidate_status;
        $program->date = $request->date;
        $program->status_id = $request->status_id;
        $program->position_id = $request->position_id;
        $program->city_id = $request->city_id;
        $program->state_id = $request->state_id;
        $program->user_id = $user->id;

        $program->update();
        $user = Auth::guard('api')->user();
        $progra = Resumelog::create([
            'type' => 'update',
            'resume_id' => $program->id,
            'status_id' => $program->status_id,
            'user_id' => $user->id,

        ]);
        $user = Auth::guard('api')->user();
        $userlog = UserLog::create([
            'action' => 'Updata',
            'module' => 'Resume',
            'user_id' => $user->id,
            'resume_id' => $program->id,
        ]);
        return response()->json([
            'success' => 'True',
            'message' => 'Resume updated successfully.',
            'data' => $program,
            'new data' => $progra,
            'user' => $userlog
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $program = Resume::find($id);
        $user = Auth::guard('api')->user();
        $progra = Resumelog::create([
            'type' => 'delete',
            'user_id' => $user->id,
        ]);
        $userlog = Userlog::create([
            'action' => 'Delete',
            'module' => 'Resume',
            'user_id' => $user->id,
        ]);
        if (!empty($program)) {
            $program->delete();
            return response()->json([
                'success' => true,
                'message' => ' delete successfuly',
                'data' => $progra,
                'user' => $userlog
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'something wrong try again ',
            ]);
        }
    }

    public function getAll()
    {
        $Currency = Currency::latest()->get();
        $position = Position::latest()->get();
        $client = Client::latest()->get();
        $user = User::latest()->get();
        $result = ['currency' => $Currency, 'position' => $position, 'client' => $client , 'user'=>$user];
        return response()->json([
            'success' => 'True',
            'message' => 'All Data susccessfull',
            'data' => $result,
        ]);
    }
    public function storeLog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //   'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $program = ResumeLog::create([
            'status_id' => $request->status_id,
            'user_id' => $request->user_id,

        ]);
        if (is_null($program)) {
            return response()->json('storage error',);
        }
        return response()->json([
            'success' => 'True',
            'message' => 'Resume created successfully',
            'data' => $program,
        ]);
    }

    public function geLog($id)
    {
        $program = ResumeLog::with('resume', 'status', 'user')
            ->whereIn('resume_id', [$id])->get();


        if (is_null($program)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([
            'success' => 'True',
            'data' => $program,
        ]);
    }
}
