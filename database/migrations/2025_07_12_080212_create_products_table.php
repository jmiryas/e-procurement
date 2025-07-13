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
            $table->unsignedBigInteger('vendor_id');
            $table->enum('unit', ['pcs', 'box'])->default('pcs');
            $table->string('name', 50);
            $table->integer('qty')->default(1);
            $table->decimal('price', 12, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors');
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
