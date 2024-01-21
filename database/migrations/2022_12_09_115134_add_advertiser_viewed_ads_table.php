<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Advert;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisers_viewed_ads', function (Blueprint $table) {
            $table->bigInteger('advertiser_id');
            $table->foreignIdFor(Advert::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->dateTime('viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisers_viewed_ads');
    }
};
