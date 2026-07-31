<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Business;
use App\Models\Jeep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;


class JeepTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();


        Role::firstOrCreate(['name' => 'Admin']);

        Role::firstOrCreate(['name' => 'Jeep Owner']);

        Role::firstOrCreate(['name' => 'Jeep Driver']);

        Role::firstOrCreate(['name' => 'Tourist']);

        Role::firstOrCreate(['name' => 'Transport Owner']);
    }



    private function createJeepOwner()
    {
        $user = User::factory()->create();

        $user->assignRole('Jeep Owner');

        return $user;
    }



    private function createTourist()
    {
        $user = User::factory()->create();

        $user->assignRole('Tourist');

        return $user;
    }



    private function createBusiness($owner)
    {
        return Business::create([
            'owner_id' => $owner->id,
            'business_name' => 'Safari Business',
            'registration_number' => 'REG-' . rand(1000, 9999),
            'business_type' => 'JEEP',
            'description' => 'Safari jeep business',
            'contact_number' => '0771234567',
            'address' => 'Wilpattu Park Road',
        ]);
    }

    private function jeepData($business)
    {
        return [
            'business_id' => $business->id,
            'registration_number' => 'CAB-' . rand(1000, 9999),
            'brand' => 'Toyota',
            'model' => 'Land Cruiser',
            'year' => 2023,
            'seat_capacity' => 6,
            'fuel_type' => 'Diesel',
            'transmission' => 'Manual',
            'features' => [
                'GPS',
                'First Aid Kit',
            ],
            'description' => 'Safari Jeep',
            'status' => 'Available',
        ];
    }

    public function test_jeep_owner_can_create_jeep()
    {
        $owner = $this->createJeepOwner();
        $business = $this->createBusiness($owner);

        $response = $this
            ->actingAs($owner)
            ->postJson(
                '/api/jeeps',
                $this->jeepData($business)
            );

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_tourist_cannot_create_jeep()
    {
        $tourist = $this->createTourist();
        $business = $this->createBusiness($tourist);

        $response = $this
            ->actingAs($tourist)
            ->postJson(
                '/api/jeeps',
                $this->jeepData($business)
            );

        $response
            ->assertStatus(403);
    }

    public function test_owner_can_update_own_jeep()
    {
        $owner = $this->createJeepOwner();
        $business = $this->createBusiness($owner);

        $jeep = Jeep::create(
            $this->jeepData($business)
        );

        $response = $this
            ->actingAs($owner)
            ->putJson(
                "/api/jeeps/{$jeep->id}",
                array_merge($this->jeepData($business), [
                    'model' => 'Updated Jeep',
                ])
            );

        $response
            ->assertStatus(200);
    }

    public function test_owner_cannot_update_other_business_jeep()
    {
        $owner1 = $this->createJeepOwner();
        $owner2 = $this->createJeepOwner();

        $business = $this->createBusiness($owner1);

        $jeep = Jeep::create(
            $this->jeepData($business)
        );

        $response = $this
            ->actingAs($owner2)
            ->putJson(
                "/api/jeeps/{$jeep->id}",
                array_merge($this->jeepData($business), [
                    'model' => 'Hack Update',
                ])
            );

        $response
            ->assertStatus(403);
    }





    public function test_owner_can_assign_driver()
    {

        $owner=$this->createJeepOwner();


        $driver=User::factory()->create();

        $driver->assignRole('Jeep Driver');



        $business=$this->createBusiness($owner);



        $jeep=Jeep::create(
            $this->jeepData($business)
        );



        $response=$this
            ->actingAs($owner)
            ->patchJson(
                "/api/jeeps/$jeep->id/assign-driver",
                [
                    'driver_id'=>$driver->id
                ]
            );



        $response
            ->assertStatus(200);

    }




    public function test_owner_can_change_status()
    {

        $owner=$this->createJeepOwner();


        $business=$this->createBusiness($owner);



        $jeep=Jeep::create(
            $this->jeepData($business)
        );



        $response=$this
            ->actingAs($owner)
            ->patchJson(
                "/api/jeeps/$jeep->id/change-status",
                [
                    'status'=>'Maintenance'
                ]
            );


        $response
            ->assertStatus(200);

    }



}