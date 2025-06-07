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
        $cards = [
            ['title' => 'Earnings', 'description' => 'Total earnings for this client', 'position' => 1],
            ['title' => 'Profit', 'description' => 'Net profit generated', 'position' => 2],
            ['title' => 'Revenue', 'description' => 'Total revenue generated', 'position' => 3],
            ['title' => 'Pay Date', 'description' => 'Next payment date', 'position' => 4],
            ['title' => 'Total', 'description' => 'Total amount accumulated', 'position' => 5],
            ['title' => 'Status', 'description' => 'Current account status', 'position' => 6],
        ];

        foreach ($cards as $card) {
            DashboardCard::create($card);
        }
    }
}