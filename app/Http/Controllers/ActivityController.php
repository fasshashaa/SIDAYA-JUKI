<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
{
    // Mengambil semua aktivitas, diurutkan dari yang terbaru
    $activities = \App\Models\Activity::latest()->paginate(20); 
    return view('activities.index', compact('activities'));
}
}
