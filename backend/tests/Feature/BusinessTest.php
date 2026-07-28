<?php

namespace Tests\Feature;

use App\Enums\BusinessType;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_jeep_owner_can_create_business(): void
    {

        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $user->assignRole(Role::JEEP_OWNER->value);

        $response = $this
            ->actingAs($user)
            ->postJson('/api/businesses', [
                'business_name' => 'Wilpattu Safari Tours',
                'description' => 'test',
                'registration_number' => 'WP-001',
                'business_type' => BusinessType::JEEP->value,
                'contact_number' => '0771234567',
                'email' => 'safari@example.com',
                'address' => 'Wilpattu',
            ]);

        $response
            ->assertCreated()
            ->assertJsonPath(
                'data.business_name',
                'Wilpattu Safari Tours'
            );
    }

    public function test_transport_owner_can_create_business(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $user->assignRole(Role::TRANSPORT_OWNER->value);

        $response = $this
            ->actingAs($user)
            ->postJson('/api/businesses', [
                'business_name' => 'Wilpattu Transport',
                'description' => 'test',
                'registration_number' => 'TR-001',
                'business_type' => BusinessType::TRANSPORT->value,
                'contact_number' => '0771234567',
                'email' => 'transport@example.com',
                'address' => 'Puttalam',
            ]);

        $response->assertCreated();
    }

    public function test_tourist_cannot_create_business(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $user->assignRole(Role::TOURIST->value);

        $response = $this
            ->actingAs($user)
            ->postJson('/api/businesses', [
                'business_name' => 'Not Allowed',
                'description' => 'test',
                'registration_number' => 'NO-001',
                'business_type' => BusinessType::JEEP->value,
                'contact_number' => '0771234567',
                'address' => 'Wilpattu',
            ]);

        $response->assertForbidden();
    }

    public function test_owner_can_update_own_business(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $user->assignRole(Role::JEEP_OWNER->value);

        $business = $user->business()->create([
            'business_name' => 'Old Name',
              'description' => 'test',
            'registration_number' => 'WP-002',
            'business_type' => BusinessType::JEEP->value,
            'contact_number' => '0771234567',
            'email' => null,
            'address' => 'Wilpattu',
        ]);

        $response = $this
            ->actingAs($user)
            ->putJson("/api/businesses/{$business->id}", [
                'business_name' => 'New Name',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath(
                'data.business_name',
                'New Name'
            );
    }

    public function test_owner_cannot_update_another_users_business(): void
    {
        /** @var \App\Models\User $ownerA */
        $ownerA = User::factory()->create();

        $ownerA->assignRole(Role::JEEP_OWNER->value);

        $ownerB = User::factory()->create();
        $ownerB->assignRole(Role::JEEP_OWNER->value);

        $business = $ownerB->business()->create([
            'business_name' => 'Owner B Business',
              'description' => 'test',
            'registration_number' => 'WP-003',
            'business_type' => BusinessType::JEEP->value,
            'contact_number' => '0771234567',
            'email' => null,
            'address' => 'Wilpattu',
        ]);

        $response = $this
            ->actingAs($ownerA)
            ->putJson("/api/businesses/{$business->id}", [
                'business_name' => 'Hacked Business',
            ]);

        $response->assertForbidden();
    }

    public function test_business_registration_validation_works(): void
    {
       /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $user->assignRole(Role::JEEP_OWNER->value);

        $response = $this
            ->actingAs($user)
            ->postJson('/api/businesses', []);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'business_name',
                  'description',
                'registration_number',
                'business_type',
                'contact_number',
                'address',
            ]);
    }
}
