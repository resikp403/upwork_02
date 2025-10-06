<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function index()
    {   

        $profiles = Profile::with('freelancer.location')->get();

        return response()->json([
           'status' => 1,
           'data' => $profiles,
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $profile = Profile::with('freelancer.location')->find($id);

        if (!$profile) {
            return response()->json([
                'status' => 0,
                'message' => 'Profile not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 1,
            'data' => $profile,
        ], Response::HTTP_OK);
    }
}
