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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')
                ->constrained();
            $table->decimal('amount', 8, 2);
            $table->enum('pix_key_type', ['cpf, cnpj, phone, email, random']);
            $table->string('pix_key');
            $table->enum('status', ['pending', 'completed', 'failed']);
            $table->string('external_tx_id');
            $table->datetime('requested_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal');
    }
};
