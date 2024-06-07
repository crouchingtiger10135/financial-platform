<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Document;
use App\Models\Invitation;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $pendingInvitations = Invitation::count();
        $documentsUploaded = Document::count();
        $verificationComplete = Client::where('verified', true)->count();
        $recentActivities = []; // Fetch recent activities
        $recentDocuments = Document::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalClients',
            'pendingInvitations',
            'documentsUploaded',
            'verificationComplete',
            'recentActivities',
            'recentDocuments'
        ));
    }
}
