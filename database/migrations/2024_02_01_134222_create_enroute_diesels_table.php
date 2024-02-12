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
        Schema::create('enroute_diesels', function (Blueprint $table) {
            $table->id();
            $table->string('driver_id');
            $table->string('trip_id');
            $table->string('quantity');
            $table->string('unit_price');
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
        Schema::dropIfExists('enroute_diesels');
    }
};
