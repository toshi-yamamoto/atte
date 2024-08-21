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

    // 出勤時間を打刻
    public function startWork(Request $request)
    {
        $currentUser = Auth::id();
        // サーバーサイドで現在の日時を取得
        $workStartTime = Carbon::now();
        $attendanceDate = Carbon::today()->toDateString();

        // ログインユーザーが既に勤務中でないか確認
        if (Attendance::where('user_id', $currentUser)
                ->whereNull('work_end_time') // work_end_timeカラムがNULLであるレコードをフィルタリング
                ->exists()) { // フィルタリングされた結果に一致するレコードがデータベースに存在するかどうかを確認

            return redirect()->back()->withErrors('既に勤務中です'); // ↑trueならリダイレクト、falseならエラーメッセージ
        }

        // 出勤時間を保存
        Attendance::create([
            'user_id' => $currentUser,
            'work_start_time' => $workStartTime,
            'attendance_date' => $attendanceDate,
        ]);

        return redirect()->back()->with('message', '勤務開始を記録しました');
    }

    // 退勤時間を打刻
    public function endWork(Request $request)
    {
        $currentUser = Auth::id();
        $workEndTime = Carbon::now();
   
        $attendance = Attendance::where('user_id', $currentUser)
            ->whereNull('work_end_time') // work_end_timeカラムがNULLであるレコードをフィルタリング
            ->firstOrFail(); // クエリの結果から最初のレコードを取得

        // 退勤時間を保存
        // Attendance::update([
        //     'work_end_time' => $workEndTime,
        // ]);

        $attendance->work_end_time = $workEndTime;
        $attendance->save();

        return redirect()->back()->with('message', '勤務終了を記録しました');
    }

    public function startBreak (Request $request)
    {
        $currentUser = Auth::id();
        // サーバーサイドで現在の時刻を取得
        $breakStartTime = Carbon::now()->toTimeString();

        // ログインユーザーがまだ終了していない記録を取得
        $attendance = Attendance::where('user_id', $currentUser)
            ->whereNull('work_end_time') //勤務終了がNULLのレコードをフィルタリング
            ->firstOrFail();

        // 休憩開始を保存
        $attendance->breakTimes()->create([
            'break_start_time' => $breakStartTime,
        ]);
        
        return redirect()->back()->with('message', '休憩開始を記録しました');
    }

    public function endBreak() 
    {
        $currentUser = Auth::id();
        // サーバーサイドで現在の時刻を取得
        $currentTime = Carbon::now()->toTimeString();

        // 勤務終了ではなくかつ休憩開始されている記録を取得
        $attendance = Attendance::where('user_id', $currentUser)
            ->whereNull('work_end_time')
            // ->whereNotNull('break_start_time')
            ->firstOrFail(); // クエリの結果から最初のレコードを取得

        $breakEndTime = $attendance->breakTimes()
            ->whereNull('break_end_time')
            ->firstOrFail();

        // 休憩終了を保存
        $breakEndTime->update([
            'break_end_time' => $currentTime,
        ]);

            return redirect()->back()->with('message', '休憩終了を記録しました');
    }
}
