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
        Schema::create('ride_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')
                ->constrained('users');
            $table->foreignId('driver_id')
                ->constrained('users');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled']);
            $table->decimal('calculated_price', 8, 2);
            $table->decimal('plataform_fee', 8, 2);
            $table->string('pickup_address');
            $table->text('message')
                ->nullable();
            $table->timestamp('responded_at')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_requests');
    }
};
