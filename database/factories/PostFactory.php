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
            'title' => fake()->sentence(),
            'content' => fake()->text(),
            'image' => "posts/" . fake()->uuid() . ".jpg",
            'category_id' => fake()->randomElement([1, 2, 3, 4, 5]),
            'user_id' => fake()->randomElement(User::all()->pluck('id')->toArray())
        ];
    }
}
