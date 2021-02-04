<?php

namespace Database\Factories;

use App\Models\Order_item;
use Illuminate\Database\Eloquent\Factories\Factory;

class Order_itemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order_item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productId = $this->faker->numberBetween(1, 20);
        $orderId = $this->faker->unique($reset = true)->numberBetween(1, 15);
        $quantity = $this->faker->numberBetween(0, 3);
        $price = $this->faker->randomFloat(null, 5, 20);

        return [
            'productId' => $productId,
            'orderId' => $orderId,
            'quantity' => $quantity,
            'price' => $price
        ];
    }
}
