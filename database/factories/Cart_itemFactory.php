<?php

namespace Database\Factories;

use App\Models\Cart_item;
use Illuminate\Database\Eloquent\Factories\Factory;

class Cart_itemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart_item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productId = $this->faker->numberBetween(1, 20);
        $cartId = $this->faker->unique($reset = true)->numberBetween(1, 15);
        $quantity = $this->faker->numberBetween(0, 3);

        return [
            'productId' => $productId,
            'cartId' => $cartId,
            'quantity' => $quantity
        ];
    }
}
