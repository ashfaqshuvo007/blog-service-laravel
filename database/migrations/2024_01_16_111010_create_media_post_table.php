<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media_post', function (Blueprint $table) {
            $table->foreignId('media_id')->constrained('media');
            $table->foreignId('post_id')->constrained('posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media_post', function (Blueprint $table) {
            $table->dropForeign(['media_id']);
            $table->dropForeign(['post_id']);
            $table->dropIfExists();
        });
    }
};
