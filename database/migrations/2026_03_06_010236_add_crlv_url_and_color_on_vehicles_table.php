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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('crlv_url')
                ->nullable();
            $table->string('color')
                ->nullable();
            $table->string('situation')
                ->nullable();
            $table->string('fuel_type')
                ->nullable();
            $table->string('reviewed_by')
                ->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected']);
            $table->string('reject_reason')
                ->nullable();
            $table->timestamp('reviewed_at')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('crlv_url');
            $table->dropColumn('color');
            $table->dropColumn('situation');
            $table->dropColumn('fuel_type');
            $table->dropColumn('reviewed_by');
            $table->dropColumn('status');
            $table->dropColumn('reject_reason');
        });
    }
};
