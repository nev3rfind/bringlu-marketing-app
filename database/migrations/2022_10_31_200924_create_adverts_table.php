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
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('advert_name');
            $table->string('industry');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('description');
            $table->boolean('current_status');
            $table->bigInteger('priority_level');
            $table->text('comments');
            $table->string('creator_ip_address', 45);
            $table->string('web_url');
            $table->integer('max_advertisers_count');
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
        Schema::dropIfExists('adverts');
    }
};
