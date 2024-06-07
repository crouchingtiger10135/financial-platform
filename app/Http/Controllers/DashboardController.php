<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('dashboard', compact('clients'));
    }
}
