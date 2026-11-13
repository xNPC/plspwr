<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->text('description_ru')->nullable()->after('title_en');
            $table->text('description_en')->nullable()->after('description_ru');
            $table->string('section')->nullable()->unique()->after('template');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['description_ru', 'description_en', 'section']);
        });
    }
};