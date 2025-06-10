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
            'name' => 'Le Thu Trang',
            'email' => 'admin@foxecom.com',
            'email_verified_at' => null,
            'password' => Hash::make('password123'),
            'title' => 'Agency',
            'company_website' => 'https://foxecom.com',
            'account_type' => 2, // Business customer (admin)
            'remember_token' => null,
            'github_id' => null,
        ]);

        // Sample user data
        $users = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'title' => 'Solo developer',
                'company_website' => 'https://smithdev.com',
                'account_type' => 1,
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'title' => 'Agency',
                'company_website' => 'https://johnsondigital.com',
                'account_type' => 1,
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@example.com',
                'title' => 'Merchants/Store owners',
                'company_website' => 'https://brownecommerce.com',
                'account_type' => 1,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'title' => 'Solo developer',
                'company_website' => 'https://davisweb.com',
                'account_type' => 1,
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@example.com',
                'title' => 'Agency',
                'company_website' => 'https://wilsoncreative.com',
                'account_type' => 1,
            ],
            [
                'name' => 'Lisa Miller',
                'email' => 'lisa.miller@example.com',
                'title' => 'Freelance Web Designer',
                'other_title' => 'Freelance Web Designer',
                'company_website' => 'https://millerdesign.com',
                'account_type' => 1,
            ],
            [
                'name' => 'Robert Garcia',
                'email' => 'robert.garcia@example.com',
                'title' => 'Merchants/Store owners',
                'company_website' => 'https://garciastore.com',
                'account_type' => 1,
            ],
            [
                'name' => 'Jennifer Martinez',
                'email' => 'jennifer.martinez@example.com',
                'title' => 'Agency',
                'company_website' => 'https://martinezdigital.com',
                'account_type' => 1,
            ],
            [
                'name' => 'James Anderson',
                'email' => 'james.anderson@example.com',
                'title' => 'Solo developer',
                'company_website' => 'https://andersontech.com',
                'account_type' => 1,
            ],
            [
                'name' => 'Maria Rodriguez',
                'email' => 'maria.rodriguez@example.com',
                'title' => 'E-commerce Consultant',
                'other_title' => 'E-commerce Consultant',
                'company_website' => 'https://rodriguezconsulting.com',
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