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
        Schema::create('sales_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('idCustomers')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('idProducts')->references('id')->on('products')->onDelete('cascade');
            $table->date('expDate');
            $table->decimal('qty', 10, 2);
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('total');
            $table->unsignedTinyInteger('status')->default(0); // 0 = Draft, 1 = Sent, 2 = Confirmed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_quotations');
    }
};
