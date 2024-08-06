<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
// use App\Http\Controllers\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        return view('/', compact('user'));
    }

    // 出勤打刻
    public function startWork(Request $request)
    {
        // サーバーサイドで現在の日時を取得
        $startTime = Carbon::now();
        $attendanceDate = Carbon::today()->toDateString();

        // 既に勤務中でないか確認
        if (Attendance::where('user_id', Auth::id())->whereNull('work_end_time')->exists()) {
            return redirect()->back()->withErrors('既に勤務中です');
        }

        $attendance = new Attendance();
        $attendance->user_id = Auth::id();
        $attendance->work_start_time = $startTime;
        $attendance->attendance_date = $attendanceDate;
        $attendance->save();

        return redirect()->back()->with('message', '勤務開始を記録しました');
    }

    // 退勤打刻
    public function endWork(Request $request)
    {
        // サーバーサイドで現在の時刻を取得
        $endTime = Carbon::now(); 
   
        $attendance = Attendance::where('user_id', Auth::id())->whereNull('work_end_time')->firstOrFail();
        $attendance->work_end_time = $endTime;

        // 勤務時間の計算
        $startHour = Carbon::parse($attendance->work_start_time);
        $endHour = Carbon::parse($attendance->work_end_time);

        $totalWorkTimeSeconds = $endHour->diffInSeconds($startHour);
        $attendance->total_work_time = $totalWorkTimeSeconds;

        $attendance->save();

        return redirect()->back()->with('message', '勤務終了を記録しました');
    }
}
