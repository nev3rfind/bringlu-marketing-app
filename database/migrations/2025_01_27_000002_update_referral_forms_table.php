<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referral_forms', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn([
                'referral_name',
                'company',
                'address',
                'template',
                'expected_revenue'
            ]);
            
            // Add new columns based on the Google Form
            $table->text('referral_details')->after('user_id'); // For the text area question
            $table->enum('theme_type', ['minimog', 'megamog', 'other'])->after('referral_details');
            $table->string('other_theme')->nullable()->after('theme_type'); // For "Other" option
            $table->string('purchase_email')->after('other_theme'); // Email used to purchase theme
            $table->string('license_code')->nullable()->after('purchase_email'); // Theme license code
            $table->string('shopify_store_url')->nullable()->after('license_code'); // For non-Minimog/Megamog themes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referral_forms', function (Blueprint $table) {
            // Add back old columns
            $table->string('referral_name')->after('user_id');
            $table->string('company')->after('referral_name');
            $table->text('address')->after('company');
            $table->string('template')->after('address');
            $table->decimal('expected_revenue', 10, 2)->after('template');
            
            // Drop new columns
            $table->dropColumn([
                'referral_details',
                'theme_type',
                'other_theme',
                'purchase_email',
                'license_code',
                'shopify_store_url'
            ]);
        });
    }
};