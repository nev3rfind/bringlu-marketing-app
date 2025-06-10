<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DashboardCardValue;
use App\Models\DashboardCard;
use App\Models\User;
use Carbon\Carbon;

class DashboardCardValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing values
        DashboardCardValue::truncate();
        
        // Get all partners (account_type = 1)
        $partners = User::where('account_type', 1)->get();
        $cards = DashboardCard::all();

        foreach ($partners as $partner) {
            foreach ($cards as $card) {
                // Generate realistic values based on card type
                $value = $this->generateRealisticValue($card->title, $partner);
                
                // Create some history entries (inactive values)
                for ($i = 0; $i < rand(2, 5); $i++) {
                    DashboardCardValue::create([
                        'user_id' => $partner->id,
                        'dashboard_card_id' => $card->id,
                        'value' => $this->generateRealisticValue($card->title, $partner),
                        'is_active' => false,
                        'created_at' => Carbon::now()->subDays(rand(10, 60)),
                        'updated_at' => Carbon::now()->subDays(rand(5, 30)),
                    ]);
                }

                // Create current active value
                DashboardCardValue::create([
                    'user_id' => $partner->id,
                    'dashboard_card_id' => $card->id,
                    'value' => $value,
                    'is_active' => true,
                    'created_at' => Carbon::now()->subDays(rand(1, 7)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 3)),
                ]);
            }
        }
    }

    private function generateRealisticValue($cardTitle, $partner)
    {
        switch ($cardTitle) {
            case 'Referral':
                return rand(5, 25) . ' referrals';
            case 'Commission Earned':
                return '$' . number_format(rand(500, 5000), 2);
            case 'Date of Payout':
                $dates = ['Feb 15, 2025', 'Mar 1, 2025', 'Mar 15, 2025', 'Apr 1, 2025'];
                return $dates[array_rand($dates)];
            case 'N/A':
                return 'Not set';
            default:
                return 'Not set';
        }
    }
}