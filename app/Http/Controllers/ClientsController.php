<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

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

    /**
     * Show dashboard for a specific client
     *
     * @param User $client
     * @return \Illuminate\Http\Response
     */
    public function dashboard(User $client)
    {
        // Ensure the client is an advertiser
        if ($client->account_type !== 1) {
            abort(404);
        }

        return view('business.clients.dashboard', compact('client'));
    }

    /**
     * Show forms for a specific client
     *
     * @param User $client
     * @return \Illuminate\Http\Response
     */
    public function forms(User $client)
    {
        // Ensure the client is an advertiser
        if ($client->account_type !== 1) {
            abort(404);
        }

        return view('business.clients.forms', compact('client'));
    }
}