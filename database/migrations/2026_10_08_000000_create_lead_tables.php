<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable()->unique();
            $table->string('type', 30)->index();
            $table->string('status', 30)->default('new')->index();
            $table->string('name', 120);
            $table->string('email', 160)->nullable()->index();
            $table->string('phone', 40)->nullable();
            $table->string('preferred_contact', 20)->nullable();
            $table->string('product', 60)->nullable()->index();
            $table->string('summary', 255)->nullable();
            $table->text('message')->nullable();
            $table->json('data')->nullable();
            $table->json('source')->nullable();
            $table->unsignedTinyInteger('score')->default(0);
            $table->unsignedInteger('estimated_premium')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->boolean('is_sample')->default(false);
            $table->timestamps();
        });

        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 30);
            $table->text('body')->nullable();
            $table->timestamps();
        });

        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255)->index();
            $table->string('route', 80)->nullable();
            $table->string('visitor', 64)->index();
            $table->string('utm_source', 80)->nullable();
            $table->string('utm_medium', 80)->nullable();
            $table->string('utm_campaign', 120)->nullable();
            $table->string('referrer_host', 120)->nullable();
            $table->timestamp('viewed_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
        Schema::dropIfExists('lead_activities');
        Schema::dropIfExists('leads');
    }
};
