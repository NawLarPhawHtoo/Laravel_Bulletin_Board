<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = [
            [
              'name' => 'Admin',
              'email' => 'admin@gmail.com',
              'password' => Hash::make('123456'),
              'profile' => '',
              'type' => '0',
              'created_user_id' => 1,
              'updated_user_id' => 1,
            ],
            [
              'name' => 'User',
              'email' => 'user@gmail.com',
              'password' => Hash::make('123456'),
              'profile' => '',
              'type' => '1',
              'created_user_id' => 2,
              'updated_user_id' => 2,
            ],
          ];
          foreach ($user as $key => $value) {
            User::create($value);
          }
    }
}
