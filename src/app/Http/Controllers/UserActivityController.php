<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        return response()->json($user?->toArray());
    }
}
