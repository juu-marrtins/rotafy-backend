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
        Schema::table('driver_documents', function (Blueprint $table) {
            $table->renameColumn('file_path', 'cnh_verse_url');
            $table->text('cnh_front_url');
            $table->text('handle_cnh_url');
            $table->foreignId('driver_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driver_documents', function (Blueprint $table) {
            $table->renameColumn('cnh_verse_url', 'file_path');
            $table->dropColumn('cnh_front_url');
            $table->dropColumn('handle_cnh_url');
            $table->dropForeign('driver_documents_reviewed_by_foreign');
        });
    }
};
