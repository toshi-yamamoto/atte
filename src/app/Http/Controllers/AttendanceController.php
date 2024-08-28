<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::all();

        return view('attendances', compact('attendances'));
    }

    // 出勤時間を保存
    public function startWork(Request $request)
    {
        $currentUserId = Auth::id();
        $currentTime = Carbon::now();

        // 既に勤務中の記録を取得
        $ongoingAttendance = Attendance::where('user_id', $currentUserId)->whereNull('work_end_time')->first();

        if ($ongoingAttendance) {
            $workStartTime = Carbon::parse($ongoingAttendance->work_start_time);

            if ($workStartTime->isSameDay($currentTime)) {
                return redirect()->back()->withErrors('既に勤務中です');
            } else {
                $ongoingAttendance->work_end_time = $workStartTime->endOfDay();
                $ongoingAttendance->save();
            }
        }

        // 出勤時間を保存
        Attendance::create([
            'user_id' => $currentUserId,
            'work_start_time' => $currentTime,
            'attendance_date' => $currentTime,
        ]);

        return redirect()->back()->with('message', '勤務開始を記録しました');
    }

    // 退勤時間を打刻
    public function endWork(Request $request)
    {
        $currentUserId = Auth::id();

        $attendance = Attendance::where('user_id', $currentUserId)->whereNull('work_end_time')->first();

        if (!$attendance) {
            return redirect()->back()->withErrors('勤務終了できる記録がありません');
        }

        $attendance->work_end_time = Carbon::now();
        $attendance->save();

        return redirect()->back()->with('message', '勤務終了を記録しました');
    }

    public function startBreak(Request $request)
    {
        $currentUserId = Auth::id();

        // ログインユーザーがまだ終了していない記録を取得
        $attendance = Attendance::where('user_id', $currentUserId)->whereNull('work_end_time')->first();

        if (!$attendance) {
            return redirect()->back()->withErrors('休憩開始できる記録がありません');
        }

        // 終了していない休憩がないか確認
        $ongoingBreak = $attendance->breakTimes()->whereNull('break_end_time')->first();

        if ($ongoingBreak) {
            // 進行中の休憩がある場合、新しい休憩を開始しない
            return redirect()->back()->withErrors('現在進行中の休憩があります');
        }

        // 新しい休憩開始を保存
        $attendance->breakTimes()->create([
            'break_start_time' => Carbon::now(),
        ]);

        return redirect()->back()->with('message', '休憩開始を記録しました');
    }

    public function endBreak()
    {
        $currentUserId = Auth::id();

        // 勤務終了ではなくかつ休憩開始されている記録を取得
        $attendance = Attendance::where('user_id', $currentUserId)->whereNull('work_end_time')->first();

        if (!$attendance) {
            return redirect()->back()->withErrors('休憩終了できる記録がありません');
        }

        $ongoingBreak = $attendance->breakTimes()->whereNull('break_end_time')->first();

        if (!$ongoingBreak) {
            return redirect()->back()->withErrors('進行中の休憩がありません');
        }

        // 休憩終了を保存
        $ongoingBreak->update([
            'break_end_time' => Carbon::now(),
        ]);

        return redirect()->back()->with('message', '休憩終了を記録しました');
    }
}
