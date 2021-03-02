<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Cart_item;
use App\Models\Order_item;
use App\Models\Order;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);

        Product::factory(50)->create();
        Cart::factory(15)->create();
        Cart_item::factory(13)->create();
        Order::factory(15)->create();
        Order_item::factory(15)->create();

    }
}
