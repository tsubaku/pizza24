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
        $title = $this->faker->unique()->sentence(rand(1, 3), true); //sentence - предложение (3-8 слов)
        //$title = $this->faker->asciify('gfshfksjfhaaeee'); //sentence - предложение (3-8 слов)
        $categoryId = rand(1, 3);
        $description = $this->faker->realText(rand(1000, 3000)); //realText - текст 1000-3000 символов
        $isPublished = rand(1, 5) > 1;//1 из 5 неопубликован
        $price = $this->faker->randomFloat(null, 5, 20);
        $imageUrl = '';

        return [
            'title' => $title,
            'slug' => \Str::slug($title),
            'categoryId' => $categoryId,
            'description' => $description,
            'price' => $price,
            'imageUrl' => $imageUrl,
            'isPublished' => $isPublished
        ];
    }
}