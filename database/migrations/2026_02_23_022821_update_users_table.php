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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('university_id')
                ->constrained();
            $table->string('phone', 11);
            $table->string(' photo_url');
            $table->enum('user_title', ['student', 'teacher', 'employee']);
            $table->enum('user_type', ['driver', 'passenger', 'both']);
            $table->enum('status', ['pending', 'verified', 'rejected']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_university_id_foreign');
            $table->dropColumn([
                'phone',
                'photo_url',
                'user_title',
                'user_type',
                'status',
            ]);
        });
    }
};
