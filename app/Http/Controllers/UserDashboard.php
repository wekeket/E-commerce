<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboard extends Controller
{
    public function user(Request $request)
    {
        return view(
            'user.index',
        );
    }
}
