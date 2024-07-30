<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $attendance = $request->only(['work_start_time']);
        Attendance::create($attendance);

        return view('/attendances');
    }
}
