# NewsCMS – Professional News Portal (Laravel 10+)

Built from scratch. By one developer. To the very last pixel.

**This isn’t just a website. This is a victory.**

## Features (everything works perfectly)

- Full-featured admin panel  
- News & Categories management  
- Powerful Media Library (better than WordPress)  
  - Drag & drop upload  
  - Live search  
  - Pagination inside modal (100% unbreakable)  
  - Delete with confirmation  
  - Image picker with preview  
  - Files saved with original names (no random hashes!)  
- Choose image from library or upload directly  
- Smart duplicate handling (`photo.jpg` → `photo-1.jpg`, `photo-2.jpg`, …)  
- Beautiful SVG buttons, Bootstrap 5, fully responsive  
- Pagination + search in all lists (news, categories, media)  
- Optimized for local use – no slow queries, zero errors  

## Tech Stack

- Laravel 10+  
- MySQL  
- Bootstrap 5  
- Vanilla JavaScript (no Vue/React – pure power!)  
- Laravel Filesystem (public/storage)  
- Eloquent, Blade templates, Migrations  

## Installation (Local Development)


```bash
git clone <your-repo-or-just-copy-the-folder>
cd news-cms
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed   # optional: creates admin user if you have a seeder
php artisan storage:link
php artisan serve



For import need to add in .env

WP_DB_CONNECTION=mysql_wp
WP_DB_HOST=127.0.0.1
WP_DB_PORT=3306
WP_DB_DATABASE=webex_bier1
WP_DB_USERNAME=root
WP_DB_PASSWORD=

Add to config/database.php

'mysql_wp' => [
            'driver' => 'mysql',
            'host' => env('WP_DB_HOST', '127.0.0.1'),
            'port' => env('WP_DB_PORT', '3306'),
            'database' => env('WP_DB_DATABASE', 'forge'),
            'username' => env('WP_DB_USERNAME', 'forge'),
            'password' => env('WP_DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'strict' => false,
            'engine' => null,
        ],


command : php artisan import:wordpress