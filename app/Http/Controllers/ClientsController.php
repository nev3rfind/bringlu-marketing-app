<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\DashboardCard;
use App\Models\DashboardCardValue;
use App\Models\DashboardCardHistory;

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
        
        return view('business.clients.index', compact('clients'));
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

        // Get all dashboard cards with their values for this client
        $dashboardCards = DashboardCard::where('is_active', true)
            ->orderBy('position')
            ->get()
            ->map(function ($card) use ($client) {
                $value = $card->getValueForUser($client->id);
                $card->current_value = $value ? $value->value : 'N/A';
                return $card;
            });

        return view('business.clients.dashboard', compact('client', 'dashboardCards'));
    }

    /**
     * Update dashboard card value
     *
     * @param Request $request
     * @param User $client
     * @param DashboardCard $card
     * @return \Illuminate\Http\Response
     */
    public function updateCardValue(Request $request, User $client, DashboardCard $card)
    {
        $request->validate([
            'value' => 'required|string|max:255'
        ]);

        // Get current value
        $currentValue = DashboardCardValue::where('user_id', $client->id)
            ->where('dashboard_card_id', $card->id)
            ->first();

        $oldValue = $currentValue ? $currentValue->value : null;
        $newValue = $request->value;

        // Update or create the value
        DashboardCardValue::updateOrCreate(
            [
                'user_id' => $client->id,
                'dashboard_card_id' => $card->id
            ],
            [
                'value' => $newValue
            ]
        );

        // Create history record
        DashboardCardHistory::create([
            'user_id' => $client->id,
            'dashboard_card_id' => $card->id,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'changed_at' => now()
        ]);

        return redirect()->route('clients.dashboard', $client)
            ->with('success', 'Dashboard card updated successfully');
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