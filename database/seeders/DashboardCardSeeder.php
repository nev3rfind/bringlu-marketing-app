<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DashboardCard;

class DashboardCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing cards
        DashboardCard::truncate();
        
        $cards = [
            ['title' => 'Referral', 'description' => 'Total referrals made', 'position' => 1],
            ['title' => 'Commission Earned', 'description' => 'Total commission earned', 'position' => 2],
            ['title' => 'Date of Payout', 'description' => 'Next payout date', 'position' => 3],
            ['title' => 'N/A', 'description' => 'Not set', 'position' => 4],
            ['title' => 'N/A', 'description' => 'Not set', 'position' => 5],
            ['title' => 'N/A', 'description' => 'Not set', 'position' => 6],
        ];

        foreach ($cards as $card) {
            DashboardCard::create($card);
        }
    }
}