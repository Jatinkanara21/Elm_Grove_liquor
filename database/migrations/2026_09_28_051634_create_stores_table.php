<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('address');
            $t->string('city')->nullable();
            $t->string('state', 50)->nullable();
            $t->string('zip', 20)->nullable();
            $t->string('phone', 30)->nullable();
            $t->string('email')->nullable();
            $t->text('opening_hours')->nullable();
            $t->decimal('latitude', 10, 7)->nullable();
            $t->decimal('longitude', 10, 7)->nullable();
            $t->string('google_maps_url', 500)->nullable();
            $t->string('image')->nullable();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
            $t->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};