<?php

namespace App\Http\Controllers\API;

use App\Models\Api\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GrahamCampbell\ResultType\Success;
use App\Http\Resources\ProductResource;
use App\Models\Api\City;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{

    public function index()
    {
        $data = City::latest()->with('state')->get();
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

        $program = City::create([
            'name' => $request->name,
            'state_id' => $request->state_id,

        ]);
        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
            'action' => 'Create',
            'module' => 'City',
            'user_id' => $user->id,
            'city_id' => $program->id,

        ]);

        if (is_null($program)) {
            return response()->json('storage error',);
        }
        return response()->json([
            'success' => 'True',
            'message' => 'City created successfully',
            'data' => $program,
            'userlog' => $progra

        ]);
    }

    public function show($id)
    {
        $program = City::find($id);
        $program ->state;
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
        $program = City::find($id);
        $program->name = $request->name;
        $program->state_id = $request->state_id;

        $program->update();
        $user = Auth::guard('api')->user();
        $progra = UserLog::create([
            'action' => 'Updata',
            'module' => 'City',
            'user_id' => $user->id,
            'city_id' => $program->id,


        ]);
        return response()->json([
            'success' => 'True',
            'message' => 'City updated successfully.',
            'data' => $program,
            'user' => $progra,

        ]);
    }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $progra = Userlog::create([
            'action' => 'delete',
            'module' => 'City',
            'user_id' => $user->id,
        ]);
        $program = City::find($id);
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

}
