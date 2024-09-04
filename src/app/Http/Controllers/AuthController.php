<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Attendance;
class AuthController extends Controller
{
    // public function index ()
    // {
    //     return view('index');
    // }

        public function index(Request $request)
    {
        // $currentUser = auth()->user();
        $currentUser = Auth::user();

        // dd($currentUser);

        // $attendance = Attendance::where('user_id', $currentUser->id)->whereDate('attendance_date', now())->first();

        $attendance = Attendance::where('user_id', $currentUser->id)->whereNull('work_end_time')->first();

        // dd($attendance);

        return view('index', compact('currentUser', 'attendance'));
    }
}
