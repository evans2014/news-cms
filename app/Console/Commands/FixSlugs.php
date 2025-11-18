<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Category;

class FixSlugs extends Command
{
    protected $signature = 'fix:slugs';
    protected $description = 'Поправя всички slug-ове';

    public function handle()
    {
        Category::all()->each(function ($cat) {
            $newSlug = Str::slug($cat->name);
            if ($cat->slug !== $newSlug) {
                $cat->slug = $newSlug;
                $cat->saveQuietly();
                $this->info("{$cat->name} → {$newSlug}");
            }
        });

        $this->info('Готово!');
    }
}