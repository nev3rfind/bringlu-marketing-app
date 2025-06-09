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
                'referral_details' => 'I referred a client who runs a fashion boutique. They were looking for a modern, responsive Shopify theme for their online store. After showing them the Minimog theme features and demo, they were impressed with the clean design and mobile optimization.',
                'theme_type' => 'minimog',
                'purchase_email' => 'fashionboutique@example.com',
                'license_code' => 'MIN-2024-001-ABC',
                'status' => 'accepted',
            ],
            [
                'referral_details' => 'Referred a tech startup that needed a professional e-commerce solution. They chose Megamog theme for their electronics store due to its advanced product filtering and modern layout. The client was particularly impressed with the theme\'s performance optimization.',
                'theme_type' => 'megamog',
                'purchase_email' => 'techstartup@example.com',
                'license_code' => 'MEG-2024-002-XYZ',
                'status' => 'pending',
            ],
            [
                'referral_details' => 'A local restaurant owner wanted to expand online with food delivery. I recommended the Minimog theme for its clean food presentation and easy navigation. They purchased it after seeing the demo and were very satisfied with the customization options.',
                'theme_type' => 'minimog',
                'purchase_email' => 'restaurant@example.com',
                'license_code' => 'MIN-2024-003-DEF',
                'status' => 'accepted',
            ],
            [
                'referral_details' => 'Referred a fitness equipment company that needed a robust e-commerce platform. They selected Megamog for its product showcase capabilities and integrated review system. The theme perfectly matched their brand requirements.',
                'theme_type' => 'megamog',
                'purchase_email' => 'fitnessco@example.com',
                'license_code' => 'MEG-2024-004-GHI',
                'status' => 'accepted',
            ],
            [
                'referral_details' => 'A jewelry designer was looking for an elegant theme to showcase their handcrafted pieces. I suggested Minimog due to its beautiful image galleries and sophisticated design. They were thrilled with the final result.',
                'theme_type' => 'minimog',
                'purchase_email' => 'jewelrydesign@example.com',
                'license_code' => 'MIN-2024-005-JKL',
                'status' => 'pending',
            ],
            [
                'referral_details' => 'Referred a home decor business that wanted to create an immersive shopping experience. Megamog theme was perfect for their needs with its advanced product visualization and category management features.',
                'theme_type' => 'megamog',
                'purchase_email' => 'homedecor@example.com',
                'license_code' => 'MEG-2024-006-MNO',
                'status' => 'rejected',
            ],
            [
                'referral_details' => 'A book publisher needed an online store for their publications. I recommended a custom theme solution that would work well with their existing brand guidelines and content management needs.',
                'theme_type' => 'other',
                'other_theme' => 'Custom Publishing Theme',
                'purchase_email' => 'publisher@example.com',
                'license_code' => null,
                'shopify_store_url' => 'https://bookpublisher.myshopify.com',
                'status' => 'accepted',
            ],
            [
                'referral_details' => 'Referred a pet supplies store that wanted a fun, colorful theme. They chose Minimog and customized it with pet-friendly colors and imagery. The store owner was very happy with the conversion rates after launch.',
                'theme_type' => 'minimog',
                'purchase_email' => 'petsupplies@example.com',
                'license_code' => 'MIN-2024-007-PQR',
                'status' => 'accepted',
            ],
            [
                'referral_details' => 'A luxury watch retailer needed a premium theme that would reflect their brand\'s exclusivity. Megamog theme provided the perfect balance of elegance and functionality for their high-end products.',
                'theme_type' => 'megamog',
                'purchase_email' => 'luxurywatches@example.com',
                'license_code' => 'MEG-2024-008-STU',
                'status' => 'pending',
            ],
            [
                'referral_details' => 'Referred a sustainable clothing brand that values eco-friendly design. They appreciated Minimog\'s clean, minimalist approach which aligned perfectly with their brand values and sustainability message.',
                'theme_type' => 'minimog',
                'purchase_email' => 'sustainableclothing@example.com',
                'license_code' => 'MIN-2024-009-VWX',
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
                if ($template['license_code']) {
                    $template['license_code'] = strtoupper(substr($template['theme_type'], 0, 3)) . '-2024-' . str_pad(($index * 10 + $i + 1), 3, '0', STR_PAD_LEFT) . '-' . chr(65 + $i) . chr(65 + $index) . chr(65 + rand(0, 25));
                }

                ReferralForm::create([
                    'user_id' => $partner->id,
                    'referral_details' => $template['referral_details'],
                    'theme_type' => $template['theme_type'],
                    'other_theme' => $template['other_theme'] ?? null,
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