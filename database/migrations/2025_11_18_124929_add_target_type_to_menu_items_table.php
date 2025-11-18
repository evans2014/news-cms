<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('target_type')->nullable()->after('type');
        });

        // Попълваме target_type от type (еднократно)
        \DB::statement("UPDATE menu_items SET target_type = CONCAT(UPPER(SUBSTRING(type, 1, 1)), SUBSTR(type, 2), 's') WHERE type IN ('page','news','category') AND target_id IS NOT NULL");
        \DB::statement("UPDATE menu_items SET target_type = 'App\\\\Models\\\\Page' WHERE type = 'page'");
        \DB::statement("UPDATE menu_items SET target_type = 'App\\\\Models\\\\Category' WHERE type = 'category'");
        \DB::statement("UPDATE menu_items SET target_type = 'App\\\\Models\\\\News' WHERE type = 'news'");
    }
};
