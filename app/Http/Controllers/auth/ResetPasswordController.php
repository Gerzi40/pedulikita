<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function create()
    {
        return view('auth.reset-password');
    }

    public function store(Request $request)
    {

    }
}
