<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_id = $this->faker->numberBetween(1, 20);
        $order_id = $this->faker->unique($reset = true)->numberBetween(1, 15);
        $quantity = $this->faker->numberBetween(0, 3);
        $price = $this->faker->randomFloat(null, 5, 20);

        return [
            'product_id' => $product_id,
            'order_id' => $order_id,
            'quantity' => $quantity,
            'price' => $price
        ];
    }
}
