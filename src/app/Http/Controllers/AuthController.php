<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
class AuthController extends Controller
{
    public function index()
    {
        $currentUserId = Auth::user();

        $disableStartWorkButton = Attendance::disableStartWorkButton($currentUserId);

        $disableEndWorkButton = Attendance::disableEndWorkButton($currentUserId);

        $disableStartBreakButton = Attendance::disableStartBreakButton($currentUserId);

        $disableEndBreakButton = Attendance::disableEndBreakButton($currentUserId);

        return view('index', compact('currentUserId', 'disableStartWorkButton', 'disableEndWorkButton', 'disableStartBreakButton', 'disableEndBreakButton'));
    }
}
