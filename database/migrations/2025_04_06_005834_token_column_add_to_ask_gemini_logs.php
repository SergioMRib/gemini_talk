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
        Schema::table('ask_gemini_logs', function (Blueprint $table) {
            $table->integer('token_count')->nullable();
            $table->integer('total_token_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ask_gemini_logs', function (Blueprint $table) {
            $table->dropColumn('token_count');
            $table->dropColumn('total_token_count');
        });
    }
};
