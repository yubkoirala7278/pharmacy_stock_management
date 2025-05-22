<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Antibiotics', 'description' => 'Medications used to treat bacterial infections.'],
            ['name' => 'Painkillers', 'description' => 'Medications for pain relief, including analgesics and NSAIDs.'],
            ['name' => 'Antacids', 'description' => 'Medications to neutralize stomach acid and relieve indigestion.'],
            ['name' => 'Antihistamines', 'description' => 'Medications for allergies and histamine-related conditions.'],
            ['name' => 'Cardiovascular', 'description' => 'Medications for heart and blood vessel conditions.'],
            ['name' => 'Antidiabetics', 'description' => 'Medications to manage diabetes and blood sugar levels.'],
            ['name' => 'Vitamins', 'description' => 'Supplements to support overall health and nutrition.'],
            ['name' => 'Antivirals', 'description' => 'Medications to treat viral infections.'],
            ['name' => 'Antifungals', 'description' => 'Medications to treat fungal infections.'],
            ['name' => 'Topical', 'description' => 'Medications applied to the skin or mucous membranes.'],
        ];

        foreach ($categories as $key => $category) {
            Category::create([
                'name'=>$category['name'],
                'description'=>$category['description']
            ]);
        }
    }
}
