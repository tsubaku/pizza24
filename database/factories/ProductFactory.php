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
        $sentence = $this->faker->unique()->sentence(mt_rand(1, 3), true);
        $title = substr($sentence, 0, -1);
        $category_id = mt_rand(2, 4);
        $description = $this->faker->realText(mt_rand(100, 300));
        $is_published = mt_rand(1, 5) > 1;
        $price = $this->faker->randomFloat(null, 5, 20);

        return [
            'title' => $title,
            'slug' => \Str::slug($title),
            'category_id' => $category_id,
            'description' => $description,
            'price' => $price,
            'image_url' => '',
            'is_published' => $is_published
        ];
    }
}
