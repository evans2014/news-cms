<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(4),
            'image' => 'news/' . $this->faker->uuid() . '.jpg',
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
    }
}