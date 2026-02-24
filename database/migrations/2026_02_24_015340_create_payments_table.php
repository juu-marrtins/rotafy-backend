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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')
                ->constrained();
            $table->foreignId('payer_id')
                ->constrained('users');
            $table->foreignId('receiver_id')
                ->constrained('users');
            $table->decimal('gross_amount', 8, 2);
            $table->decimal('plataform_fee', 8, 2);
            $table->decimal('net_amount', 8, 2);
            $table->enum('method', ['pix', 'cash', 'credit_card']);
            $table->enum('status', ['pending', 'paid', 'refunded', 'failed']);
            $table->timestamp('paid_at')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
