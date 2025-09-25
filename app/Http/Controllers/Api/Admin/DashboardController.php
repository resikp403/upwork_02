<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 1,
            'data' => auth('api')->user()->tokens,
        ], Response::HTTP_OK);
    }
}
