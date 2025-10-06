<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Freelancer; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {   
        $freelancers = Freelancer::with('location')->get();

        return response()->json([
            'status' => 1,
            'data' => $freelancers,

        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $freelancer = Freelancer::find($id);

        if (!$freelancer) {
            return response()->json([
                'status' => 0,
                'message' => 'Freelancer not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 1,
            'data' => $freelancer,
        ], Response::HTTP_OK);
    }

    public function update(Request $request,$id)
    {
        $freelancer = Freelancer::find($id);

        if (!$freelancer) {
            return response()->json([
                'status' => 0,
                'message' => 'Freelancer not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => ['sometimes', 'string', 'max:50'],
            'last_name' => ['sometimes', 'string', 'max:50'],
            'username' => ['sometimes', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors(),
            ], 422);
        }

        if ($request->has('first_name')) {
            $freelancer->first_name = $request->first_name;
        }

        if ($request->has('last_name')) {
            $freelancer->last_name = $request->last_name;
        }

        if ($request->has('username')) {
            $freelancer->username = bcrypt($request->username);
        }

        $freelancer->save();

        return response()->json([
            'status' => 1,
            'message' => 'Freelancer updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $freelancer = Freelancer::find($id);

        if (!$freelancer) {
            return response()->json([
                'status' => 0,
                'message' => 'Freelancer not found',
            ], 404);
        }

        $freelancer->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Freelancer deleted successfully',
        ]);
    }

    public function filter(Request $request)
    {
        $query = Freelancer::query();

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->input('location_id'));
        }

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }

        if ($request->filled('verified')) {
            $query->where('verified', $request->input('verified'));
        }

        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->input('min_rating'));
        }

        if ($request->filled('max_jobs')) {
            $query->where('total_jobs', '<=', $request->input('max_jobs'));
        }

        $freelancers = $query->with('location')->get();

        return response()->json([
            'status' => 1,
            'data' => $freelancers,
        ], Response::HTTP_OK);
    }
}
