<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = implode(' ', $this->faker->words(5));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraph,
            'author_id' => User::factory()
        ];
    }
}
