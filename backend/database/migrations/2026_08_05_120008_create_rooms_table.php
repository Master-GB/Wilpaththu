<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {

            $table->id();

            $table->foreignId('hotel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('room_number');

            $table->string('room_name');

            $table->text('description')
                ->nullable();

            $table->enum('room_type', [
                'Single',
                'Double',
                'Twin',
                'Triple',
                'Family',
                'Suite',
                'Dormitory',
            ]);

            $table->unsignedInteger('floor_number')
                ->default(1);

            $table->unsignedTinyInteger('max_adults');

            $table->unsignedTinyInteger('max_children')
                ->default(0);

            $table->unsignedTinyInteger('max_occupancy');

            $table->enum('bed_type', [
                'Single',
                'Double',
                'Queen',
                'King',
                'Bunk',
                'Sofa Bed',
            ]);

            $table->unsignedTinyInteger('bed_count');

            $table->decimal('room_size', 8, 2)
                ->nullable();

            $table->enum('room_size_unit', [
                'sqm',
                'sqft',
            ])->default('sqm');

            $table->json('view_types')
                ->nullable();

            $table->enum('bathroom_type', [
                'Private',
                'Shared',
            ])->default('Private');

            $table->boolean('smoking_allowed')
                ->default(false);

            $table->boolean('pets_allowed')
                ->default(false);

            $table->boolean('accessible_room')
                ->default(false);

            $table->json('amenities')
                ->nullable();

            $table->enum('status', [
                'Active',
                'Inactive',
                'Maintenance',
            ])->default('Active');

            $table->timestamps();

            $table->softDeletes();

            $table->unique([
                'hotel_id',
                'room_number',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};