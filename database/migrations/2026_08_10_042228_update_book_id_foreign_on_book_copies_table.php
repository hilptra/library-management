<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_copies', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('book_copies', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->foreign('book_id')->references('id')->on('books');
        });
    }
};