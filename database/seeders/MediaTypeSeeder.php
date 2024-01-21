<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdvertMedia;
use File;

class MediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the data file
        $json = File::get("database/data/media_types.json");
        //Convert JSON Object to PHP Object
        $mediaTypes = json_decode($json);

        foreach($mediaTypes as $key => $value){
            AdvertMedia::create([
                "media_name" => $value->media_name,
                "is_active" => $value->is_active
            ]);
        }
    }
}
