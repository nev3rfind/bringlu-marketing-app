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
        // Clear existing users
        User::truncate();

        // Create the admin user (Le Thu Trang)
        User::create([
            'first_name' => 'Le Thu',
            'last_name' => 'Trang',
            'phone' => '+84901234567',
            'email' => 'admin@foxecom.com',
            'email_verified_at' => null,
            'password' => Hash::make('password123'),
            'title' => 'Agency',
            'company_name' => 'FoxEcom',
            'company_website' => 'https://foxecom.com',
            'paypal_email' => 'admin@foxecom.com',
            'commission_structure_id' => 2, // Megamog
            'company_type_id' => 2, // Business customer (admin)
            'account_type' => 2, // Business
            'remember_token' => null,
            'github_id' => null,
        ]);

        // Sample user data
        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'phone' => '+1234567890',
                'email' => 'john.smith@example.com',
                'title' => 'Solo developer',
                'company_name' => 'Smith Development',
                'company_website' => 'https://smithdev.com',
                'paypal_email' => 'john.smith@paypal.com',
                'commission_structure_id' => 2, // Megamog
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'phone' => '+1234567891',
                'email' => 'sarah.johnson@example.com',
                'title' => 'Agency',
                'company_name' => 'Johnson Digital Agency',
                'company_website' => 'https://johnsondigital.com',
                'paypal_email' => 'sarah.johnson@paypal.com',
                'commission_structure_id' => 1, // Minimog
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'phone' => '+1234567892',
                'email' => 'michael.brown@example.com',
                'title' => 'Merchants or store owners',
                'company_name' => 'Brown E-commerce',
                'company_website' => 'https://brownecommerce.com',
                'paypal_email' => 'michael.brown@paypal.com',
                'commission_structure_id' => 3, // Zest
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'phone' => '+1234567893',
                'email' => 'emily.davis@example.com',
                'title' => 'Solo developer',
                'company_name' => 'Davis Web Solutions',
                'company_website' => 'https://davisweb.com',
                'paypal_email' => 'emily.davis@paypal.com',
                'commission_structure_id' => 1, // Minimog
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Wilson',
                'phone' => '+1234567894',
                'email' => 'david.wilson@example.com',
                'title' => 'Agency',
                'company_name' => 'Wilson Creative Agency',
                'company_website' => 'https://wilsoncreative.com',
                'paypal_email' => 'david.wilson@paypal.com',
                'commission_structure_id' => 4, // Sleek
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Miller',
                'phone' => '+1234567895',
                'email' => 'lisa.miller@example.com',
                'title' => 'Freelance Web Designer',
                'other_title' => 'Freelance Web Designer',
                'company_name' => 'Miller Design Studio',
                'company_website' => 'https://millerdesign.com',
                'paypal_email' => 'lisa.miller@paypal.com',
                'commission_structure_id' => 1, // Minimog
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Garcia',
                'phone' => '+1234567896',
                'email' => 'robert.garcia@example.com',
                'title' => 'Merchants or store owners',
                'company_name' => 'Garcia Online Store',
                'company_website' => 'https://garciastore.com',
                'paypal_email' => 'robert.garcia@paypal.com',
                'commission_structure_id' => 5, // Hyper
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'Jennifer',
                'last_name' => 'Martinez',
                'phone' => '+1234567897',
                'email' => 'jennifer.martinez@example.com',
                'title' => 'Agency',
                'company_name' => 'Martinez Digital',
                'company_website' => 'https://martinezdigital.com',
                'paypal_email' => 'jennifer.martinez@paypal.com',
                'commission_structure_id' => 2, // Megamog
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Anderson',
                'phone' => '+1234567898',
                'email' => 'james.anderson@example.com',
                'title' => 'Solo developer',
                'company_name' => 'Anderson Tech',
                'company_website' => 'https://andersontech.com',
                'paypal_email' => 'james.anderson@paypal.com',
                'commission_structure_id' => 1, // Minimog
                'company_type_id' => 1,
                'account_type' => 1,
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Rodriguez',
                'phone' => '+1234567899',
                'email' => 'maria.rodriguez@example.com',
                'title' => 'E-commerce Consultant',
                'other_title' => 'E-commerce Consultant',
                'company_name' => 'Rodriguez Consulting',
                'company_website' => 'https://rodriguezconsulting.com',
                'paypal_email' => 'maria.rodriguez@paypal.com',
                'commission_structure_id' => 3, // Zest
                'company_type_id' => 1,
                'account_type' => 1,
            ],
        ];

        // Create users with password123
        foreach ($users as $userData) {
            User::create(array_merge($userData, [
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => null,
                'github_id' => null,
            ]));
        }
    }
}