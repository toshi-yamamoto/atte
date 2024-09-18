<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'work_start_time',
        'work_end_time',
        'break_start_time',
        'break_end_time',
        'attendance_date',
    ];

    public function disableStartWorkButton($currentUserId)
    {
        $ongoingAttendance = self::where('user_id', $currentUserId->id)->whereNull('work_end_time')->first();

        if ($ongoingAttendance && Carbon::parse($ongoingAttendance->attendance_date)->isSameDay(Carbon::now())){
            return true;
        } else {
            return false;
        }
    }

    public function disableEndWorkButton($currentUserId)
    {
        $ongoingAttendance = self::where('user_id', $currentUserId->id)->whereNull('work_end_time')->first();

        if (!$ongoingAttendance || !$ongoingAttendance->work_start_time || $ongoingAttendance->work_end_time || $ongoingAttendance->breakTimes->whereNull('break_end_time')->isNotEmpty()){
            return true;
        } else {
            return false;
        }
    }

    public function disableStartBreakButton($currentUserId)
    {
        $ongoingAttendance = self::where('user_id', $currentUserId->id)->whereNull('work_end_time')->first();

        if (!$ongoingAttendance || !$ongoingAttendance->work_start_time || $ongoingAttendance->work_end_time || 
            ($ongoingAttendance->breakTimes && $ongoingAttendance->breakTimes->whereNull('break_end_time')->isNotEmpty())) {
                return true;
        } else {
            return false;
        }
    }

    public function disableEndBreakButton($currentUserId)
    {
        $ongoingAttendance = self::where('user_id', $currentUserId->id)->whereNull('work_end_time')->first();

        if (!$ongoingAttendance || !$ongoingAttendance->work_start_time || $ongoingAttendance->work_end_time || !$ongoingAttendance->breakTimes->whereNull('break_end_time')->isNotEmpty()) {
                return true;
            }
            return false;
    }

    public static function recordStartWork($currentUserId, $currentTime)
    {
        // 既に勤務中の記録を取得
        $ongoingAttendance = self::where('user_id', $currentUserId)->whereNull('work_end_time')->first();

        if ($ongoingAttendance) {
            $workStartTime = Carbon::parse($ongoingAttendance->work_start_time);

            // 日を跨いでいるかのチェック
            if (!$workStartTime->isSameDay($currentTime)) {
                // 日を跨いでいれば前日の勤務を終了
                $ongoingAttendance->update([
                    'work_end_time' => $workStartTime->endOfDay()
                ]);
                // 新しい勤務記録を作成
                return self::create([
                    'user_id' => $currentUserId,
                    'work_start_time' => $currentTime,
                    'attendance_date' => $currentTime,
                ]);
            } else {
                // 同一日内であれば新しい記録は作成しない
                return $ongoingAttendance;
            }
        }

        return self::create([
            'user_id' => $currentUserId,
            'work_start_time' => $currentTime,
            'attendance_date' => $currentTime,
        ]);
    }

    public static function recordEndWork($currentUserId, $currentTime)
    {
        $ongoingAttendance = self::where('user_id', $currentUserId)->whereNull('work_end_time')->first();

        $ongoingAttendance->update([
            'work_end_time' => $currentTime,
        ]);
    }

    public static function recordStartBreak($currentUserId, $currentTime)
    {
        $ongoingAttendance = self::where('user_id', $currentUserId)->whereNull('work_end_time')->first();

        $ongoingAttendance->breakTimes()->create([
            'break_start_time' => $currentTime,
        ]);
    }

    public static function recordEndBreak($currentUserId, $currentTime)
    {
        $ongoingAttendance = self::where('user_id', $currentUserId)->whereNull('work_end_time')->first();

        $ongoingBreak = $ongoingAttendance->breakTimes()->whereNull('break_end_time')->first();

        $ongoingBreak->update([
            'break_end_time' => $currentTime,
        ]);
    }

    public function breakTimes()
    {
        return $this->hasMany(BreakTime::class);
    }

    public function getTotalBreakTimeAttribute()
    {
        $totalBreakTime = 0;

        foreach ($this->breakTimes as $breakTime) {
            if ($breakTime->break_end_time) {
                $start = Carbon::parse($breakTime->break_start_time);
                $end = Carbon::parse($breakTime->break_end_time);
                $totalBreakTime += $start->diffInSeconds($end);
            }
        }

        return gmdate('H:i:s', $totalBreakTime);
    }
}
