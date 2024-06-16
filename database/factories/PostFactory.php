<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    protected $model = \App\Models\Post::class;

public function definition(): array
{
    return [
        'title' => $this->faker->sentence,
        'user_id' => $this->faker->numberBetween(1, 10),
        'content' => $this->faker->paragraph,
        'up_votes' => $this->faker->numberBetween(0, 1000),
        'down_votes' => $this->faker->numberBetween(0, 1000),
        'views' => $this->faker->numberBetween(0, 10000),
        'created_at' => now(),
    ];
}

}
