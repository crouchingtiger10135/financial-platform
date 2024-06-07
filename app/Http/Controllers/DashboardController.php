<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Activity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $recentActivity = Activity::latest()->take(10)->get();
        $statusBreakdown = [
            'pending' => Client::where('status', 'pending')->count(),
            'approved' => Client::where('status', 'approved')->count(),
            'rejected' => Client::where('status', 'rejected')->count(),
        ];

        return view('dashboard', compact('totalClients', 'recentActivity', 'statusBreakdown'));
    }
}
