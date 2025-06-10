<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReferralForm;
use App\Models\User;
use Carbon\Carbon;

class ReferralFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing referral forms
        ReferralForm::truncate();

        // Get all partner users (excluding admin)
        $partners = User::where('account_type', 1)->get();

        // Sample referral data templates
        $referralTemplates = [
            [
                'theme_type' => 'minimog',
                'purchase_email' => 'fashionboutique@example.com',
                'license_code' => 'MIN-2024-001-ABC',
                'status' => 'accepted',
            ],
            [
                'theme_type' => 'megamog',
                'purchase_email' => 'techstartup@example.com',
                'license_code' => 'MEG-2024-002-XYZ',
                'status' => 'pending',
            ],
            [
                'theme_type' => 'zest',
                'purchase_email' => 'restaurant@example.com',
                'license_code' => 'ZST-2024-003-DEF',
                'shopify_store_url' => 'https://restaurant.myshopify.com',
                'status' => 'accepted',
            ],
            [
                'theme_type' => 'sleek',
                'purchase_email' => 'fitnessco@example.com',
                'license_code' => 'SLK-2024-004-GHI',
                'shopify_store_url' => 'https://fitnessco.myshopify.com',
                'status' => 'accepted',
            ],
            [
                'theme_type' => 'hyper',
                'purchase_email' => 'jewelrydesign@example.com',
                'license_code' => 'HYP-2024-005-JKL',
                'shopify_store_url' => 'https://jewelrydesign.myshopify.com',
                'status' => 'pending',
            ],
            [
                'theme_type' => 'minimog',
                'purchase_email' => 'homedecor@example.com',
                'license_code' => 'MIN-2024-006-MNO',
                'status' => 'rejected',
            ],
            [
                'theme_type' => 'zest',
                'purchase_email' => 'publisher@example.com',
                'license_code' => 'ZST-2024-007-PQR',
                'shopify_store_url' => 'https://bookpublisher.myshopify.com',
                'status' => 'accepted',
            ],
            [
                'theme_type' => 'megamog',
                'purchase_email' => 'petsupplies@example.com',
                'license_code' => 'MEG-2024-008-STU',
                'status' => 'accepted',
            ],
            [
                'theme_type' => 'sleek',
                'purchase_email' => 'luxurywatches@example.com',
                'license_code' => 'SLK-2024-009-VWX',
                'shopify_store_url' => 'https://luxurywatches.myshopify.com',
                'status' => 'pending',
            ],
            [
                'theme_type' => 'hyper',
                'purchase_email' => 'sustainableclothing@example.com',
                'license_code' => 'HYP-2024-010-YZA',
                'shopify_store_url' => 'https://sustainableclothing.myshopify.com',
                'status' => 'accepted',
            ],
        ];

        // Users that should have NO referral forms (indices 1 and 8 - Sarah Johnson and James Anderson)
        $usersWithoutForms = [1, 8];

        foreach ($partners as $index => $partner) {
            // Skip users that shouldn't have forms
            if (in_array($index, $usersWithoutForms)) {
                continue;
            }

            // Determine number of forms for this user (1-7)
            $numForms = rand(1, 7);

            for ($i = 0; $i < $numForms; $i++) {
                $template = $referralTemplates[array_rand($referralTemplates)];
                
                // Create unique email and license code
                $template['purchase_email'] = 'client' . ($index + 1) . '_' . ($i + 1) . '@example.com';
                $template['license_code'] = strtoupper(substr($template['theme_type'], 0, 3)) . '-2024-' . str_pad(($index * 10 + $i + 1), 3, '0', STR_PAD_LEFT) . '-' . chr(65 + $i) . chr(65 + $index) . chr(65 + rand(0, 25));

                ReferralForm::create([
                    'user_id' => $partner->id,
                    'theme_type' => $template['theme_type'],
                    'purchase_email' => $template['purchase_email'],
                    'license_code' => $template['license_code'],
                    'shopify_store_url' => $template['shopify_store_url'] ?? null,
                    'status' => $template['status'],
                    'viewed' => rand(0, 1) == 1, // Random viewed status
                    'created_at' => Carbon::now()->subDays(rand(1, 30)), // Random date within last 30 days
                    'updated_at' => Carbon::now()->subDays(rand(0, 5)), // Random recent update
                ]);
            }
        }
    }
}