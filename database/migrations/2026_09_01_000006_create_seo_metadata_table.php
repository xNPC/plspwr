<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_metadata', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('seoable');
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_ru')->nullable();
            $table->string('description_en')->nullable();
            $table->text('keywords_ru')->nullable();
            $table->text('keywords_en')->nullable();
            $table->string('canonical_ru')->nullable();
            $table->string('canonical_en')->nullable();
            $table->json('og_image')->nullable();
            $table->string('robots')->nullable();
            $table->boolean('noindex')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_metadata');
    }
};
