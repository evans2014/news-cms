<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\News;
use App\Models\Media;

//php artisan import:wordpress

class ImportWordpress extends Command
{
    protected $signature = 'import:wordpress';
    protected $description = 'Import categories, posts, and media from WordPress with media files';

    // WordPress uploads
    protected $wpUploads = 'D:/laragon/www/webexample/wp-content/uploads/';

    public function handle()
    {
        $this->info('Import categories...');
        $categoryMap = []; // wp_term_id => new category id

        // We take the categories
        $wpCategories = DB::connection('mysql_wp')->table('wpbg16_terms as t')
            ->join('wpbg16_term_taxonomy as tt', 't.term_id', '=', 'tt.term_id')
            ->where('tt.taxonomy', 'category')
            ->select('t.term_id', 't.name', 't.slug')
            ->get();

        foreach ($wpCategories as $wpCat) {
            $option = DB::connection('mysql_wp')->table('wpbg16_options')
                ->where('option_name', 'z_taxonomy_image' . $wpCat->term_id)
                ->first();

            $imagePath = null;
            if ($option && $option->option_value) {
                $parsed = parse_url($option->option_value, PHP_URL_PATH);
                $imagePath = ltrim(str_replace('/wp-content/uploads/', '', $parsed), '/');
                $imagePath = $this->copyMediaFile($imagePath);
            }

            $category = Category::firstOrCreate(
                ['slug' => $wpCat->slug],
                [
                    'name' => $wpCat->name,
                    'image' => $imagePath ?? '/images/no-image.jpg',
                ]
            );

            $categoryMap[$wpCat->term_id] = $category->id;
        }

        $this->info('Categories imported successfully.');

        $this->info('Import news and media...');

        $wpPosts = DB::connection('mysql_wp')->table('wpbg16_posts')
            ->where('post_type', 'post')
            ->where('post_status', 'publish')
            ->get();

        foreach ($wpPosts as $post) {
            // We take the category of the post
            $wpCategoryIds = DB::connection('mysql_wp')->table('wpbg16_term_relationships')
                ->where('object_id', $post->ID)
                ->pluck('term_taxonomy_id')
                ->toArray();

            $categoryId = null;
            foreach ($wpCategoryIds as $wpCatId) {
                if (isset($categoryMap[$wpCatId])) {
                    $categoryId = $categoryMap[$wpCatId];
                    break;
                }
            }

            // Featured image
            $thumbnailMeta = DB::connection('mysql_wp')->table('wpbg16_postmeta')
                ->where('post_id', $post->ID)
                ->where('meta_key', '_thumbnail_id')
                ->first();

            $imagePath = null;
            if ($thumbnailMeta) {
                $attachmentId = $thumbnailMeta->meta_value;
                $attachmentMeta = DB::connection('mysql_wp')->table('wpbg16_postmeta')
                    ->where('post_id', $attachmentId)
                    ->where('meta_key', '_wp_attached_file')
                    ->first();

                if ($attachmentMeta) {
                    $imagePath = $this->copyMediaFile($attachmentMeta->meta_value);
                }
            }

            // Create News
            $news = News::create([
                'title' => $post->post_title,
                'description' => $post->post_content,
                'image' => $imagePath,
                'category_id' => $categoryId,
                'title_lower' => Str::lower($post->post_title),
                'description_lower' => Str::lower($post->post_content),
            ]);

            // Conenction category_news
            foreach ($wpCategoryIds as $wpCatId) {
                if (isset($categoryMap[$wpCatId])) {
                    DB::table('category_news')->insertOrIgnore([
                        'category_id' => $categoryMap[$wpCatId],
                        'news_id' => $news->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->info('Import completed successfully..');
    }

    protected function copyMediaFile($relativePath)
    {
        $source = $this->wpUploads . $relativePath;
        $destination = public_path('/storage/media/' . $relativePath);

        if (!file_exists($source)) {
            return null;
        }

        @mkdir(dirname($destination), 0755, true);
        copy($source, $destination);

        $dbPath = '/storage/media/' . $relativePath; // <-- NEWS/CATEGORIES


        Media::updateOrCreate(
            ['path' => $dbPath],
            [
                'name' => basename($relativePath),
                'url' => asset($dbPath),
                'mime_type' => mime_content_type($destination),
                'size' => filesize($destination),
                'uploaded_by' => 1,
            ]
        );

        return $dbPath;
    }

}
