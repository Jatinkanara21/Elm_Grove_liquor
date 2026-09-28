<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name', 100);
            $t->string('email');
            $t->string('phone', 30)->nullable();
            $t->string('subject');
            $t->text('message');
            $t->string('status', 20)->default('unread')->index(); // unread|read|replied|archived
            $t->string('ip_address', 45)->nullable();
            $t->timestamps();
            $t->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};