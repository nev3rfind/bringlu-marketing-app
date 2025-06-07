<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\ClientDashboard;
use App\Models\DashboardHistory;
use App\Models\ClientForm;
use Carbon\Carbon;

class ClientsController extends Controller
{
    /**
     * Show all clients (advertisers) for business customers
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        // Get all users with account_type = 1 (advertisers)
        $clients = User::where('account_type', 1)->get();
        dd($clients);
        //return view('business.clients.index', compact('clients'));
        return view('business.clients.index')
            ->with([
                'clients' => $clients
            ]);
    }
}