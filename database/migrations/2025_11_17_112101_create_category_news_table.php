<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('news_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['category_id', 'news_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_news');
    }

};
