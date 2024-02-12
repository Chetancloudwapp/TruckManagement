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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('loading_location');
            $table->string('offloading_location');
            $table->date('start_date');
            $table->date('end_date');
            $table->float('revenue');
            $table->string('type_of_cargo');
            $table->integer('truck');
            $table->integer('driver');
            $table->string('weight_of_cargo');
            $table->integer('initial_diesel');
            $table->string('mileage');
            $table->string('movement_sheet');
            $table->string('road_toll');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
