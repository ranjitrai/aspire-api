<?php

namespace Tests;
use App\User;
use Laravel\Passport\Passport;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public $apiUser;

     public function setUp(): void
    {
        parent::setUp();
        \DB::beginTransaction();
         
         $this->artisan('migrate:refresh');
         $this->artisan('passport:install');
    }

    public function tearDown(): void
    {
        \DB::rollback();
        parent::tearDown();
    }
}
