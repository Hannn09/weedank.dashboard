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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('idProducts')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('idIngredients')->references('id')->on('ingredients')->onDelete('cascade');
            $table->decimal('qtyBom', 10, 2);
            $table->unsignedInteger('qtyProduct'); 
            $table->unsignedBigInteger('productCost');
            $table->unsignedBigInteger('bomCost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
