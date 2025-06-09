<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->text('referral_details'); // For the text area question
            $table->enum('theme_type', ['minimog', 'megamog', 'other']);
            $table->string('other_theme')->nullable(); // For "Other" option
            $table->string('purchase_email'); // Email used to purchase theme
            $table->string('license_code')->nullable(); // Theme license code
            $table->string('shopify_store_url')->nullable(); // For non-Minimog/Megamog themes
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->boolean('viewed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_forms');
    }
};