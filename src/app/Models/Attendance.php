<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // protected $attributes = [
    //     'attendance_date' => 1111-11-11,
    // ];

    protected $fillable = [
        'work_start_time'
    ];
}
