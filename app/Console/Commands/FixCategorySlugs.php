<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixCategorySlugs extends Command
{
    protected $signature = 'categories:fix-slugs';
    protected $description = 'Поправя всички slug-ове на категории';

    public function handle()
    {
        \App\Models\Category::all()->each(function ($cat) {
            $newSlug = \Illuminate\Support\Str::slug($cat->name);
            if ($cat->slug !== $newSlug) {
                $cat->slug = $newSlug;
                $cat->saveQuietly();
                $this->info("Поправен: {$cat->name} → {$newSlug}");
            }
        });

        $this->info('Всички slug-ове са поправени!');
    }
}
