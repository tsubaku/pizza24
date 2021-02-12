<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryName = 'All';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parent_id' => 1,
            'description' => 'Root category',
            'image_url' => 'not-available.png'
        ];

        $categoryName = 'Pizza';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parent_id' => 1,
            'description' => 'All pizzas in our store',
            'image_url' => 'not-available.png'
        ];

        $categoryName = 'Pizza sauce';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parent_id' => 2,
            'description' => 'All pizza sauces in our store',
            'image_url' => 'not-available.png'
        ];

        $categoryName = 'Sushi';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parent_id' => 1,
            'description' => 'All sushi in our store',
            'image_url' => 'not-available.png'
        ];

        \DB::table('categories')->insert($data);
    }
}
