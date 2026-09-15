<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('filament_theme_settings')) {
            Schema::create('filament_theme_settings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('panel', 64)->default('default')->index();
                $table->json('settings');
                $table->timestamps();

                $table->unique(['user_id', 'panel'], 'filament_theme_user_panel_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('filament_theme_settings');
    }
};
