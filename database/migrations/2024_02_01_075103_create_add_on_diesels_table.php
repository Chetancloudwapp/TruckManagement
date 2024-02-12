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
        Schema::create('add_on_diesels', function (Blueprint $table) {
            $table->id();
            $table->string('quantity_in_litres');
            $table->string('unit_price');
            $table->string('petrol_station_image');
            $table->string('petrol_station');
            $table->SoftDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_on_diesels');
    }
};
