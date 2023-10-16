<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
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
