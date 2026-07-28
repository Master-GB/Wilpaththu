<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Seed required roles for permission checks
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
    }
}
