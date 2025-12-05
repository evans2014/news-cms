<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
// database/seeders/CategorySeeder.php
    public function run()
    {
        $categories = ['Спорт'];

        foreach ($categories as $name) {
            \App\Models\Category::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'image'       => '/images/og-default.jpg', // или null
            ]);
        }
    }
}
