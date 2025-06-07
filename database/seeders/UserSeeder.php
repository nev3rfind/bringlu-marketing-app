<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
=======
        // Clear existing users
        User::truncate();

>>>>>>> 5f6d59fae498ee0f5d648c7d8c135b5d68846f59
        // Create the admin user (Le Thu Trang)
        User::create([
            'first_name' => 'Le Thu',
            'last_name' => 'Trang',
            'phone' => '+84901234567',
            'email' => 'admin@foxecom.com',
            'email_verified_at' => null,
            'password' => Hash::make('password123'),
            'remember_token' => null,
            'account_type' => 1, // Advertiser
            'github_id' => null,
            'company_type_id' => null, // NULL for account_type 1
        ]);

        // Array of sample names for variety
        $firstNames = [
            'John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Lisa', 'James', 'Maria'
        ];
        
        $lastNames = [
            'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'
        ];

        // Create 9 additional users with account_type 2 (Business)
        for ($i = 1; $i <= 9; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            
            User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => '+1' . rand(2000000000, 9999999999), // Random US phone number
                'email' => strtolower($firstName . '.' . $lastName . $i . '@foxecom.com'),
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => null,
                'account_type' => 2, // Business
                'github_id' => null,
                'company_type_id' => rand(1, 2), // Randomly 1 or 2
            ]);
        }
    }
}