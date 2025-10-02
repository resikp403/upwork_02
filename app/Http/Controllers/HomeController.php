<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return Freelancer::with('profiles')->get();
        abort(403);
    }
}
