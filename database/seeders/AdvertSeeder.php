<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Advert;
use File;

class AdvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove all data from the existing table
        Advert::truncate();

        // Get the data file
        $json = File::get("database/data/adverts.json");
        //Convert JSON Object to PHP Object
        $adverts = json_decode($json);

        foreach($adverts as $key => $value){
            Advert::create([
                "user_id" => $value->user_id,
                "advert_category_id" => $value->category_id,
                "advert_media_id" => $value->media_id,
                "advert_name" => $value->advert_name,
                "industry" => $value->industry,
                "start_date" => $value->start_date,
                "end_date" => $value->end_date,
                "description" => $value->description,
                "current_status" => $value->current_status,
                "priority_level" => $value->priority_level,
                "web_url" => $value->web_url,
                "max_advertisers_count" => $value->max_advertisers_count,
                "comments" => $value->comments,
                "creator_ip_address" => $value->creator_ip_address
            ]);
        }

      //  Advert::factory()->count(5)->create();
    }
}
