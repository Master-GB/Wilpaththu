<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jeeps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('business_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('registration_number')->unique();

            $table->string('brand');
            $table->string('model');
            $table->year('year');

            $table->string('color')->nullable();

            $table->unsignedTinyInteger('seat_capacity');

            $table->enum('fuel_type', [
                'Petrol',
                'Diesel',
                'Hybrid',
                'Electric'
            ]);

            $table->enum('transmission', [
                'Manual',
                'Automatic'
            ]);

           $table->json('features')->nullable();

            $table->text('description')->nullable();

            $table->enum('status', [
                'Available',
                'Maintenance',
                'Inactive'
            ])->default('Available');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jeeps');
    }
};