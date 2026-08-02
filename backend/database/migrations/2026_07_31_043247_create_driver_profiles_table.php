<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_profiles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('business_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('license_number')->unique();

            $table->date('license_expiry_date');

            $table->unsignedTinyInteger('experience_years')
                ->default(0);

            $table->json('languages')->nullable();

            $table->string('phone');

            $table->string('emergency_contact')
                ->nullable();

            $table->enum('availability', [
                'Available',
                'Busy',
                'Off Duty'
            ])->default('Available');

            $table->boolean('verified')
                ->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_profiles');
    }
};