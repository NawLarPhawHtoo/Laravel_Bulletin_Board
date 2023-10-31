<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->title(),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement([1,0]),
            'created_user_id' => function () {
                return User::factory()->create([
                    'created_user_id' => 1,
                    'updated_user_id' => 1
                ])->id; // Assuming you have a User model and factory.
            },
            'updated_user_id' => function ($array) {
                return $array['created_user_id'];
            },
        ];
    }
}
