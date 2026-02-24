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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')
                ->constrained();
            $table->foreignId('rater_id')
                ->constrained('users');
            $table->foreignId('rated_id')
                ->constrained('users');
            $table->tinyInteger('rating')->unsigned()->default(5);
            $table->text('comment')
                ->nullable();
            $table->enum('type', ['passenger_to_driver', 'driver_to_passenger']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
