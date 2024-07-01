<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('music_histories', function (Blueprint $table) {
            $table->id();
            $table->string('music_id')->nullable();
            $table->text('music_url')->nullable();
            $table->text('music_name')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }


    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('music_histories');
    }
};
