<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelians')->cascadeOnDelete();
            $table->string('metode_pembayaran', 50)->default('Tunai');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->timestamps();
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
    
};
