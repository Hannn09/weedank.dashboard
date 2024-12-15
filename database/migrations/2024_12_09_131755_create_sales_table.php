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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('salesOrderCode'); // Relasi ke Sales Orders
            $table->string('quotationCode'); // Kode Sales Quotation
            $table->foreignId('idCustomers')->constrained('customers')->onDelete('cascade'); // Relasi ke Customers
            $table->unsignedBigInteger('total'); // Total nilai pesanan
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
