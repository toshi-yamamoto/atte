<?php

namespace App\Models;

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

    public function breakTimes()
    {
        return $this->hasMany(BreakTime::class);
    }

    public function getTotalBreakTimeAttribute()
    {
        $totalBreakTime = 0;

        foreach ($this->breakTimes as $breakTime) {
            if ($breakTime->break_end_time) {
                $start = \Carbon\Carbon::parse($breakTime->break_start_time);
                $end = \Carbon\Carbon::parse($breakTime->break_end_time);
                $totalBreakTime += $start->diffInSeconds($end);
            }
        }

        return gmdate('H:i:s', $totalBreakTime);
    }
}
