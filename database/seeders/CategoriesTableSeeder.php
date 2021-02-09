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
        $categoryName = '_Root category_';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parent_id' => 1,
            'description' => 'Root category',
            'image_url' => ''
        ];

        $categoryName = 'Pizza';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parent_id' => 1,
            'description' => 'All pizzas in our store',
            'image_url' => ''
        ];

        $categoryName = 'Pizza sauces';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parent_id' => 2,
            'description' => 'All pizza sauces in our store',
            'image_url' => ''
        ];

        $categoryName = 'Sushi';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parent_id' => 1,
            'description' => 'All sushi in our store',
            'image_url' => ''
        ];

        \DB::table('categories')->insert($data);
    }
}
