<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use App\Models\Page;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Admin user
        User::firstOrCreate(
            ['email' => 'admin@news.com'],
            [
                'name'     => 'Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        // 2. Categories FIRST (required before news!)
        $this->call(CategorySeeder::class);

        // 3. We create a test news item
        // 50 real-looking news items
        for ($i = 0; $i < 4; $i++) {
            $news = News::create([
                'title'       => \Faker\Factory::create('bg_BG')->realText(10),
                'description' => \Faker\Factory::create('bg_BG')->paragraphs(rand(1,2), true),
                'image'       => '/images/og-default.jpg',
            ]);


            $news->categories()->sync(
                \App\Models\Category::inRandomOrder()->limit(rand(1,4))->pluck('id')->toArray()
            );
        }


        $firstThreeCategories = \App\Models\Category::orderBy('id')->limit(1)->pluck('id')->toArray();
        $news->categories()->sync($firstThreeCategories);

        // 4. Static pages
        Page::firstOrCreate(
            ['slug' => 'about-us'],
            [
                'title'   => 'За нас',
                'content' => '<p>Това е модерна News CMS платформа, създадена с Laravel 11.</p>',
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'contact'],
            [
                'title'   => 'Контакт',
                'content' => '<p>Свържете се с нас: <a href="mailto:admin@news.com">admin@news.com</a></p>',
            ]
        );

        $this->command->info('Database seeding completed successfully!');
    }
}