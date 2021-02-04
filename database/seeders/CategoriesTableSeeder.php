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
        $categoryName = 'Pizza';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parentId' => 0,
            'description' => 'All pizzas in our store',
            'imageUrl' => ''
        ];

        $categoryName = 'Pizza sauces';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parentId' => 1,
            'description' => 'All pizza sauces in our store',
            'imageUrl' => ''
        ];

        $categoryName = 'Sushi';
        $data[] = [
            'title' => $categoryName,
            'slug' => \Str::slug($categoryName),
            'parentId' => 0,
            'description' => 'All sushi in our store',
            'imageUrl' => ''
        ];

        \DB::table('categories')->insert($data);
    }
}
