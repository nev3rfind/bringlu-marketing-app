<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DashboardCardValue;
use App\Models\DashboardCard;
use App\Models\User;

class DashboardCardValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all advertisers (account_type = 1)
        $advertisers = User::where('account_type', 1)->get();
        $cards = DashboardCard::all();

        foreach ($advertisers as $advertiser) {
            foreach ($cards as $card) {
                // Create default active values for each card
                $defaultValues = [
                    'Earnings' => '$0.00',
                    'Profit' => '$0.00',
                    'Revenue' => '$0.00',
                    'Pay Date' => 'Not Set',
                    'Total' => '$0.00',
                    'Status' => 'Active'
                ];

                DashboardCardValue::create([
                    'user_id' => $advertiser->id,
                    'dashboard_card_id' => $card->id,
                    'value' => $defaultValues[$card->title] ?? 'N/A',
                    'is_active' => true
                ]);
            }
        }
    }
}