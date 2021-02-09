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
        $user_id = $this->faker->unique()->numberBetween(3, 18);
        $session_id =  \Str::random(26);
        $name = $this->faker->name;
        $email = $this->faker->email;
        $phone = $this->faker->phoneNumber;
        $address = $this->faker->address;

        return [
            'user_id' => $user_id,
            'session_id' => $session_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];
    }
}
