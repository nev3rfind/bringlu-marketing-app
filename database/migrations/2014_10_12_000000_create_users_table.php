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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('title')->nullable(); // Solo developer, Agency, etc.
            $table->string('company_name')->nullable();
            $table->string('company_website')->nullable();
            $table->string('paypal_email')->nullable();
            $table->integer('commission_structure_id')->nullable(); // 1=Minimog, 2=Megamog, 3=Zest, 4=Sleek, 5=Hyper
            $table->text('other_title')->nullable(); // For "Other" option
            $table->integer('company_type_id')->nullable()->unsigned(); // 1=Partner, 2=Customer
            $table->unsignedBigInteger('account_type')->default(1); // All users are partners now
            $table->string('github_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};