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
        Schema::table('users', function (Blueprint $table) {
            // Add new fields based on the Google Form
            $table->string('title')->nullable()->after('last_name'); // Solo developer, Agency, etc.
            $table->string('company_name')->nullable()->after('title');
            $table->string('company_website')->nullable()->after('company_name');
            $table->string('paypal_email')->nullable()->after('company_website');
            $table->json('commission_structure')->nullable()->after('paypal_email'); // Store selected themes
            $table->text('other_title')->nullable()->after('commission_structure'); // For "Other" option
            
            // Remove old company_type_id as we're replacing it with title
            $table->dropColumn('company_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'company_name', 
                'company_website',
                'paypal_email',
                'commission_structure',
                'other_title'
            ]);
            
            // Add back the old column
            $table->integer('company_type_id')->nullable()->unsigned();
        });
    }
};