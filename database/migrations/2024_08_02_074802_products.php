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
            $table->id('product_id');
            $table->string('product_name');
            $table->decimal('product_price', 8, 2);
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->integer('no_available_products');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('products_in_cart', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->decimal('product_price', 8, 2);
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_quantity')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
