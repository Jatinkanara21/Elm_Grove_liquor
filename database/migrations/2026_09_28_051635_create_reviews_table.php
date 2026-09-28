<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $t) {
            $t->id();
            $t->string('name', 100);
            $t->string('email');
            $t->unsignedTinyInteger('rating');
            $t->text('body');
            $t->string('status', 20)->default('pending')->index(); // pending|approved|rejected
            $t->string('ip_address', 45)->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};