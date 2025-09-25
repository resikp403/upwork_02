<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Verification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Response;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'integer', 'regex:/^(6[0-5]\d{6}|71\d{6})$/'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $obj = Verification::where('username', $request->username)
            ->whereIn('status', [0, 1, 3])
            ->where('method', 0)
            ->where('updated_at', '>', now()->subMinutes(2))
            ->orderBy('id', 'desc')
            ->first();

        if ($obj) {
            $obj->update();
        } else {
            $obj = Verification::updateOrCreate([
                'username' => $request->username,
                'method' => 0,
            ], [
                'code' => rand(10000, 99999),
                'status' => 0,
            ]);
        }

        // CODE SENT
        $obj->status = 1;
        $obj->update();

        return response()->json([
            'status' => 1,
        ], Response::HTTP_OK);
    }

    public function confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'integer', 'regex:/^(6[0-5]\d{6}|71\d{6})$/'],
            'code' => ['required', 'integer', 'between:10000,99999'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $obj = Verification::where('username', $request->username)
            ->where('code', $request->code)
            ->whereIn('status', [0, 1, 3])
            ->where('method', 0)
            ->where('updated_at', '>', now()->subMinutes(2))
            ->orderBy('id', 'desc')
            ->first();

        if ($obj) {
            return response()->json([
                'status' => 1,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid verification code',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
