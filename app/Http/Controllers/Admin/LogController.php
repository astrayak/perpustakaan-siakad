<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;

class LogController extends Controller
{
    public function index()
    {
        $logs = LoginLog::with('user')->latest('login_at')->paginate(20);
        return view('admin.log.index', compact('logs'));
    }
}