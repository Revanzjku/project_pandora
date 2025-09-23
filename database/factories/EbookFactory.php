<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ebook>
 */
class EbookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => null, // or use a factory to create a category
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'year' => fake()->year(),
            'cover_image_path' => null,
            'ebook_file_path' => fake()->filePath(),
            'description' => fake()->paragraph(),
        ];
    }
}
