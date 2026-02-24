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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate', 8);
            $table->string('brand');
            $table->string('model');    
            $table->string('version')
                ->nullable();
            $table->string('year');
            $table->enum('fuel_type', ['gasoline', 'ethanol', 'flex', 'diesel', 'alcohol']);
            $table->decimal('consumption_city', 4, 1);
            $table->decimal('consumption_road', 4, 1);
            $table->decimal('consumption_mixed', 4, 1);
            $table->boolean('fetched_from_api');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
