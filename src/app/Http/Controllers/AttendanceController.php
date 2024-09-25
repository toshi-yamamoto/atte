<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    // 出勤時間を打刻
    public function startWork()
    {
        $currentUserId = Auth::id();
        $currentTime = Carbon::now();

        Attendance::recordStartWork($currentUserId, $currentTime);

        return redirect()->back()->with('message', '勤務開始を記録しました');
    }

    // 退勤時間を打刻
    public function endWork()
    {
        $currentUserId = Auth::id();
        $currentTime = Carbon::now();

        Attendance::recordEndWork($currentUserId, $currentTime);

        return redirect()->back()->with('message', '勤務終了を記録しました');
    }

    // 休憩開始を打刻
    public function startBreak()
    {
        $currentUserId = Auth::id();
        $currentTime = Carbon::now();

        Attendance::recordStartBreak($currentUserId, $currentTime);

        return redirect()->back()->with('message', '休憩開始を記録しました');
    }

    // 休憩終了を打刻
    public function endBreak()
    {
        $currentUserId = Auth::id();
        $currentTime = Carbon::now();

        Attendance::recordEndBreak($currentUserId, $currentTime);

        return redirect()->back()->with('message', '休憩終了を記録しました');
    }

    // 日付毎の勤務を表示
    public function showByDate(Request $request)
    {
        $date = $request->query('date', Attendance::max('attendance_date'));

        $attendances = Attendance::whereDate('attendance_date', $date)->paginate(5);

        $preDate = Attendance::where('attendance_date', '<', $date)
            ->orderBy('attendance_date', 'desc')
            ->value('attendance_date');

        $nextDate = Attendance::where('attendance_date', '>', $date)
            ->orderBy('attendance_date', 'asc')
            ->value('attendance_date');

        return view('attendances', compact('attendances', 'date', 'preDate', 'nextDate'));
    }
}
