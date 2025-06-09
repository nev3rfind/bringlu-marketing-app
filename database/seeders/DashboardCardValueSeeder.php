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
        // Get all partners (account_type = 1)
        $partners = User::where('account_type', 1)->get();
        $cards = DashboardCard::all();

        foreach ($partners as $partner) {
            foreach ($cards as $card) {
                // Create realistic values based on card type
                $value = $this->generateRealisticValue($card->title, $partner);

                DashboardCardValue::create([
                    'user_id' => $partner->id,
                    'dashboard_card_id' => $card->id,
                    'value' => $value,
                    'is_active' => true
                ]);
            }
        }
    }

    private function generateRealisticValue($cardTitle, $partner)
    {
        switch ($cardTitle) {
            case 'Earnings':
                return '$' . number_format(rand(500, 5000), 2);
            case 'Profit':
                return '$' . number_format(rand(200, 2000), 2);
            case 'Revenue':
                return '$' . number_format(rand(1000, 8000), 2);
            case 'Pay Date':
                $dates = ['Jan 15, 2025', 'Feb 1, 2025', 'Feb 15, 2025', 'Mar 1, 2025'];
                return $dates[array_rand($dates)];
            case 'Total':
                return '$' . number_format(rand(2000, 15000), 2);
            case 'Status':
                $statuses = ['Active', 'Pending Review', 'Verified', 'Premium'];
                return $statuses[array_rand($statuses)];
            default:
                return 'N/A';
        }
    }
}