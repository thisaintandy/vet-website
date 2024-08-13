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
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('appointment_id')->unique();
        $table->string('title');
        $table->dateTime('start');
        $table->dateTime('end')->nullable();
        $table->timestamps();

        $table->foreign('appointment_id')->references('appointment_id')->on('appointments')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
