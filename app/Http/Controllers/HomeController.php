<?php

namespace App\Http\Controllers;

use App\Models\NotifMesin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $notif = NotifMesin::where('status', 'pending')->orWhere('status', 'perbaikan')->get();
        return view('home.index', compact('notif'));
    }
}
