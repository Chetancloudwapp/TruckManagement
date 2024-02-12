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
        Schema::create('trip_starts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('driver_id');
            $table->string('exact_km_driven');
            $table->string('existing_diesel_image');
            $table->string('odometer_image');
            $table->SoftDeletes();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_starts');
    }
};