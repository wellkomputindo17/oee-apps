<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AndonSystemController extends Controller
{
    public function full()
    {
        return view('andon.full');
    }
    public function site()
    {
        return view('andon.site');
    }
}
