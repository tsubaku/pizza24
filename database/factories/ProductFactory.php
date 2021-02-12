<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->unique()->words(rand(1, 3), true); //sentence - предложение (3-8 слов)
        //$title = $this->faker->asciify('gfshfksjfhaaeee'); //sentence - предложение (3-8 слов)
        $category_id = rand(2, 4);
        $description = $this->faker->realText(rand(100, 300)); //realText - текст 1000-3000 символов
        $is_published = rand(1, 5) > 1;//1 из 5 неопубликован
        $price = $this->faker->randomFloat(null, 5, 20);
        $image_url = 'not-available.png';

        return [
            'title' => $title,
            'slug' => \Str::slug($title),
            'category_id' => $category_id,
            'description' => $description,
            'price' => $price,
            'image_url' => $image_url,
            'is_published' => $is_published
        ];
    }
}
