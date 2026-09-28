<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Informational catalog only: no price, stock, cart or checkout columns.
return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('brand')->nullable()->index();
            $t->text('short_description')->nullable();
            $t->longText('description')->nullable();
            $t->string('image')->nullable();
            $t->string('type')->nullable()->index();
            $t->string('country')->nullable();
            $t->string('region')->nullable();
            $t->decimal('alcohol_percentage', 4, 1)->nullable();
            $t->string('bottle_size')->nullable();
            $t->boolean('is_featured')->default(false)->index();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['category_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};