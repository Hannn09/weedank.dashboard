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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->foreignId('idIngredients')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreignId('idVendor')->references('id')->on('vendors')->onDelete('cascade');
            $table->unsignedInteger('qtyIngredients'); 
            $table->date('orderDate');
            $table->unsignedBigInteger('total');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
