<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userId = $this->faker->unique()->numberBetween(3, 18);
        $sessionId =  \Str::random(26);
        $name = $this->faker->name;
        $email = $this->faker->email;
        $phone = $this->faker->phoneNumber;
        $address = $this->faker->address;

        return [
            'userId' => $userId,
            'sessionId' => $sessionId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];
    }
}
