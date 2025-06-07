<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word(); // Generates a unique word for the category name

        return [
            'name' => $name,
            'slug' => Str::slug($name), // Generates a slug from the category name
            'icon' => $this->faker->boolean(50) ? $this->faker->imageUrl(64, 64, 'categories', true) : null, // 50% chance of having an icon
            'description' => $this->faker->boolean(70) ? $this->faker->paragraph() : null, // 70% chance of having a description
            'status' => $this->faker->boolean(), // Random true/false for status
            // 'parent_id', 'lft', 'rgt', 'depth' are managed by nestedSet and typically not set directly here,
            // unless you have specific nested structure testing needs.
            // For a basic factory, we can omit them as they will be handled by the package.
            'created_by' => $this->faker->numberBetween(1, 10), // Assuming these are filled by application logic or specific seeders
            'updated_by' => $this->faker->numberBetween(1, 10),
            'deleted_by' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that the category is a root category (no parent).
     */
    public function root(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => null,
            ];
        });
    }
}
