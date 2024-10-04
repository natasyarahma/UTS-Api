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
            $table->unsignedBigInteger('chategory_id');
            $table->string('product');
            $table->text('description');
            $table->double('price')->default(0);
            $table->integer('stock');
            $table->text('image');
            $table->timestamps();

            $table->foreign('chategory_id')->references('id')->on('chategories');
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
