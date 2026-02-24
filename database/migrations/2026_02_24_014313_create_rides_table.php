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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_profile_id')
                ->constrained();
            $table->string('origin_city');
            $table->string('destination_city');
            $table->decimal('origin_lat_lng', 10, 7);
            $table->decimal('destination_lat_lng', 10, 7);
            $table->decimal('distance_km', 8, 2);
            $table->datetime('departure_at');
            $table->integer('avaliable_seats')
                ->default(4);
            $table->enum('status', ['open', 'full', 'in_progress', 'completed', 'cancelled']);
            $table->decimal('fuel_price_used', 5, 2);
            $table->text('notes')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
