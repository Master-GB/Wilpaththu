<?php

use App\Enums\BusinessType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('business_name');

            $table->string('registration_number')
                ->unique();

            $table->enum(
                'business_type',
                array_column(BusinessType::cases(), 'value')
            );

            $table->text('description');

            $table->string('contact_number');

            $table->string('email')->nullable();

            $table->text('address');

            $table->boolean('is_verified')
                ->default(false);

            $table->timestamp('verified_at')
                ->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            // One owner = one business
            $table->unique('owner_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
