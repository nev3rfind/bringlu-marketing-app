<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdvertCategory;
use File;

class AdvertCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the data file
        $json = File::get("database/data/adverts_categories.json");
        // Convert JSON Object to PHP Object
        $advertCategories = json_decode($json);

        foreach($advertCategories as $key => $value){
            AdvertCategory::create([
                "category_name" => $value->category_name,
                "is_active" => $value->is_active
            ]);
        }

        
    }
}
