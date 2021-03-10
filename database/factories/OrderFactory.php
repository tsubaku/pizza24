<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->unique($reset = true)->numberBetween(3, 19);
        $status = $this->faker->numberBetween(0, 3);
        $currency = (rand(1, 4) == 4) ? "USD" : "EUR";
        $total = $this->faker->randomFloat(null, 5, 20);
        $name = $this->faker->name;
        $email = $this->faker->email;
        $phone = $this->faker->phoneNumber;
        $address = $this->faker->address;

        return [
            'user_id' => $user_id,
            'status' => $status,
            'total' => $total,
            'currency' => $currency,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];
    }
}

