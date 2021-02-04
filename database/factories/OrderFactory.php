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

        $sessionId =  \Str::random(26);
        $userId = $this->faker->unique($reset = true)->numberBetween(3, 19);
        $status = $this->faker->numberBetween(0, 3);
        $total = $this->faker->randomFloat(null, 5, 20);
        $name = $this->faker->name;
        $email = $this->faker->email;
        $phone = $this->faker->phoneNumber;
        $address = $this->faker->address;

        return [

            'sessionId' => $sessionId,
            'userId' => $userId,
            'status' => $status,
            'total' => $total,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];
    }
}

