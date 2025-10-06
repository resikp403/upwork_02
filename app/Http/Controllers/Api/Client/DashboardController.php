<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Review;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {   
        $clients = Client::with('location')->get();
        $review = Review::with('review');

        return response()->json([
            'status' => 1,
            'data' => ([$clients,
                        $review]),

        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'status' => 0,
                'message' => 'Client not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 1,
            'data' => $client,
        ], Response::HTTP_OK);
    }
}
