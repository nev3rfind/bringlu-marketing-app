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
        Schema::create('advertisers_ads_status', function (Blueprint $table) {
            $table->bigInteger('advertiser_id');
            $table->foreignIdFor(Advert::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            // afer confirmation - pending; 
            // when advert business customer (advert creator) accepts  - confirmed;
            // if advert business customer (advert creator) rejects - rejected;
            $table->string('advert_status');
            // Some extra details about advert status 
            $table->string('extra_details');
            $table->dateTime('last_actioned_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisers_ads_status');
    }
};
