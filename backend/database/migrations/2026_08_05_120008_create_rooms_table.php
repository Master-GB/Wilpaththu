<?php

use App\Enums\BedTypeEnum;
use App\Enums\RoomTypeEnum;
use App\Enums\RoomStatusEnum;
use Illuminate\Database\Migrations\Migration;
use App\Enums\BathroomTypeEnum;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\RoomSizeUnitEnum;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {

            $table->id();

            $table->foreignId('hotel_id')
                ->constrained('hotels')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('room_number');

            $table->string('room_name');

            $table->text('description')
                ->nullable();

            $table->enum(
                'room_type',
                RoomTypeEnum::values()
            );

            $table->unsignedInteger('floor_number')
                ->default(1);

            $table->unsignedTinyInteger('max_adults');

            $table->unsignedTinyInteger('max_children')
                ->default(0);

            $table->unsignedTinyInteger('max_occupancy');

            $table->enum(
                'bed_type',
                BedTypeEnum::values()
            );

            $table->unsignedTinyInteger('bed_count');

            $table->decimal('room_size', 8, 2)
                ->nullable();

            $table->enum(
                'room_size_unit',
                RoomSizeUnitEnum::values()
            )->default(RoomSizeUnitEnum::SQM->value);

            $table->json('view_types')
                ->nullable();

            $table->enum(
                'bathroom_type',
                BathroomTypeEnum::values()
            )->default(BathroomTypeEnum::PRIVATE->value);

            $table->boolean('smoking_allowed')
                ->default(false);

            $table->boolean('pets_allowed')
                ->default(false);

            $table->boolean('accessible_room')
                ->default(false);

            $table->json('amenities')
                ->nullable();

            $table->enum(
                'status',
                RoomStatusEnum::values()
            )->default(RoomStatusEnum::ACTIVE->value);

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