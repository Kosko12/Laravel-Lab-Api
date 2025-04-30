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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // Nazwa badania
            $table->text('description')->nullable();    // Opis badania
            $table->decimal('price', 8, 2);             // Cena brutto
            $table->integer('delivery_days');           // Czas realizacji (w dniach)
            $table->boolean('active')->default(true);   // Czy badanie jest dostępne
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
