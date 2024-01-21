<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\AdvertCategory;
use App\Models\AdvertMedia;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adverts', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(AdvertCategory::class)->constrained();
            $table->foreignIdFor(AdvertMedia::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adverts', function (Blueprint $table) {
            $table->dropForeign('adverts_user_id_foreign');
            $table->dropForeign('adverts_advert_category_id_foreign');
            $table->dropForeign('adverts_advert_media_id_foreign');
        });
    }
};
