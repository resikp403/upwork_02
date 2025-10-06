<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    public function index()
    {   
        $reviews = Review::with([
            'client.location',
            'freelancer.location'
            ])->get();

        return response()->json([
            'status' => 1,
            'data' => $reviews,

        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $review = Review::with([
            'client.location',
            'freelancer.location'
            ])->find($id);

        if (!$review) {
            return response()->json([
                'status' => 0,
                'message' => 'Review not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 1,
            'data' => $review,
        ], Response::HTTP_OK);
    }

    public function create(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'freelancer_id' => ['required', 'exists:freelancers,id'],
            'client_id'     => ['required', 'exists:clients,id'],
            'from'          => ['required', 'string', 'max:255'],
            'rating'        => ['required', 'integer', 'between:1,5'],
            'comment'       => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $review = Review::create([
            'uuid'          => Str::uuid(),
            'freelancer_id' => $request->freelancer_id,
            'client_id'     => $request->client_id,
            'from'          => $request->from,
            'rating'        => $request->rating,
            'comment'       => $request->comment,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Review created successfully.',
            'data' => $review,
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'status'  => 0,
                'message' => 'Review not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'from'    => 'sometimes|string|max:255',
            'rating'  => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string',
        ]);

        $review->update($validated);

        return response()->json([
            'status'  => 1,
            'message' => 'Review updated successfully',
            'data'    => $review,
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'status' => 0,
                'message' => 'Review not found',
            ], 404);
        }

        $review->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Review deleted successfully',
        ]);
    }
}
