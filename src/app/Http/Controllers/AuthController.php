<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
class AuthController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $currentTime = Carbon::now();

        $attendance = Attendance::where('user_id', $currentUser->id)->whereNull('work_end_time')->first();

        $disableStartWorkButton = false;
        if ($attendance && Carbon::parse($attendance->attendance_date)->isSameDay(Carbon::now())){
            $disableStartWorkButton = true;
        }

        $disableEndWorkButton = false;
        if (!$attendance || !$attendance->work_start_time || $attendance->work_end_time || $attendance->breakTimes->whereNull('break_end_time')->isNotEmpty()){
            $disableEndWorkButton = true;
        }

        return view('index', compact('currentUser', 'attendance', 'disableStartWorkButton', 'disableEndWorkButton'));
    }
}
