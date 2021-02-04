<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //2 administrators
        $data = [
            [
                'name' => 'Administrator',
                'email' => 'administrator@pizza24.com',
                'password' => \Hash::make('password1'),
                'admin' => true,
            ],
            [
                'name' => 'Operator',
                'email' => 'operator@pizza24.com',
                'password' => \Hash::make('password2'),
                'admin' => true,
            ]
        ];

        //15 users
        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'name' => 'User' . $i,
                'email' => \Str::random(6) . '@gmail.com',
                'password' => \Hash::make('password'.$i),
                'admin' => false
            ];
        }

        \DB::table('users')->insert($data);
    }
}
