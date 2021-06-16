<?php

namespace App\Http\Controllers;

use App\Models\UserLogs;

class UserController extends Controller
{
    public function menu()
    {
        $logs = UserLogs::getUserActivity(\Auth::user()->id);
        return view('user.main', compact('logs'));
    }
}
