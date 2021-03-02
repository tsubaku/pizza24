<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = [
            'name' => 'exchange_rate',
            'value' => 0.83
        ];

        $data[] = [
            'name' => 'delivery_costs',
            'value' => 20
        ];

        \DB::table('settings')->insert($data);
    }
}
