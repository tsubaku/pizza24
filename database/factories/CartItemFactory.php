<?php

namespace Database\Factories;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_id = $this->faker->numberBetween(1, 20);
        $cart_id = $this->faker->unique($reset = true)->numberBetween(1, 15);
        $quantity = $this->faker->numberBetween(0, 3);

        return [
            'product_id' => $product_id,
            'cart_id' => $cart_id,
            'quantity' => $quantity
        ];
    }
}
