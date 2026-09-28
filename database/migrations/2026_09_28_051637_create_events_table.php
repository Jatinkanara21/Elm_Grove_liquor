<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('headline')->nullable();
            $t->string('date_label')->nullable();
            $t->string('short_description', 500)->nullable();
            $t->longText('description')->nullable();
            $t->date('event_date')->index();
            $t->date('end_date')->nullable();
            $t->string('event_type', 40)->index();
            $t->string('hero_image')->nullable();       // 1920x900
            $t->string('thumbnail_image')->nullable();  // 1200x800
            $t->string('banner_image')->nullable();     // 1920x600
            $t->string('icon')->nullable();
            $t->string('accent_color', 20)->nullable();
            $t->boolean('is_featured')->default(false)->index();
            $t->boolean('is_published')->default(false)->index();
            $t->boolean('show_on_homepage')->default(false);
            $t->unsignedInteger('sort_order')->default(0);
            $t->string('meta_title')->nullable();
            $t->string('meta_description', 320)->nullable();
            $t->string('button_text')->nullable();
            $t->string('button_url', 500)->nullable();
            $t->timestamp('publish_from')->nullable();
            $t->timestamp('publish_until')->nullable();
            $t->boolean('show_countdown')->default(false);
            $t->timestamps();
            $t->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};