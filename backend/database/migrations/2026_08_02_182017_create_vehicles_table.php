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
        Schema::create('transport', function (Blueprint $table) {

            $table->id();

            $table->foreignId('business_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('driver_profiles')
                ->nullOnDelete();

            $table->string('vehicle_number')->unique();

            $table->enum('vehicle_type', [
                'Car',
                'SUV',
                'Van',
                'Mini Bus',
                'Bus',
                'Luxury Car',
            ]);

            $table->string('brand');

            $table->string('model');

            $table->year('year');

            $table->string('color');

            $table->unsignedTinyInteger('seat_capacity');

            $table->unsignedTinyInteger('luggage_capacity')
                ->nullable();

            $table->json('features')
                ->nullable();

            $table->enum('status', [
                'Available',
                'Maintenance',
                'Inactive',
            ])->default('Available');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};