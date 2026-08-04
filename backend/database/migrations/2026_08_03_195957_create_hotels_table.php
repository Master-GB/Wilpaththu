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
        Schema::create('hotels', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('hotel_name');

            $table->string('slug')->unique();

            $table->text('description');

            $table->string('address');

            $table->string('district');

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            $table->string('contact_number');

            $table->unsignedSmallInteger('total_rooms')
                ->default(0);

            $table->string('email');

            $table->string('website')
                ->nullable();

            $table->unsignedTinyInteger('star_rating')
                ->nullable();

            $table->decimal('guest_rating', 2, 1)
                ->default(0);

            $table->unsignedInteger('total_reviews')
                ->default(0);

            $table->enum('featured_type', [
                'None',
                'Featured',
                'Top Pick',
                'Recommended'
            ])->default('None');

            $table->json('amenities')
                ->nullable();

            $table->json('languages_spoken')
                ->nullable();

            $table->json('nearby_attractions')
                ->nullable();

            $table->string('check_in_policy');

            $table->string('check_out_policy');

            $table->text('cancellation_policy')
                ->nullable();

            $table->enum('status', [
                'Active',
                'Inactive',
            ])->default('Active');

            $table->boolean('verified')
                ->default(false);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};