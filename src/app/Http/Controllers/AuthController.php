<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // public function index ()
    // {
    //     return view('index');
    // }

        public function index(Request $request)
    {
        $user = auth()->user();

        return view('index', compact('user'));
    }
}
