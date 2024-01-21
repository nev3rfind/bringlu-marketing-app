<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use App\Models\User;
use App\Models\Advert;
use App\Models\AdvertCategory;
use App\Models\AdvertMedia;
use App\Models\AdvertStatus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Advert::truncate();
        AdvertCategory::truncate();
        AdvertMedia::truncate();

        $this->call([AdvertCategorySeeder::class]);
        $this->call([MediaTypeSeeder::class]);
        $this->call([AdvertSeeder::class]);

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
