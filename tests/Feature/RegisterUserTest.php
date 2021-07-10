<?php

namespace Tests\Feature;

use App\Loan;
use Laravel\Passport\Passport;
use Tests\TestCase;


class RegisterUserTest extends TestCase
{

    public function __construct()
    {
         parent::__construct();
    }

    /**
     * login api validation test.
     *
     */
    public function test_it_validates_input_for_register_user()
    {
           $user = \App\User::create([
                'email' => 'ranjit@example.com',
                'name' => 'ranjit',
                'password' => bcrypt('123456789qq')
            ]);
            $response = $this->postJson('/api/register', [
                 'name' => 'ranjit',
                // 'email' => 'ranjit@example.com',// validation test
                'password' => '123456789qq'
            ]);
            $decodedResponse = json_decode($response->getContent(), true);
            $this->assertArrayHasKey('errors', $decodedResponse);
    }

    /**
     * login api validation test.
     *
     */
    public function test_it_for_user_register()
    {       
            $response = $this->postJson('/api/register', [
                 'name' => 'ranjit',
                'email' => 'ranjit@example.com',
                'password' => '123456789qq'
            ]);
            $decodedResponse = json_decode($response->getContent(), true);
            $response->assertStatus(200);
            $decodedResponse = json_decode($response->getContent(), true);
            $this->assertArrayHasKey('access_token', $decodedResponse);
            $this->assertArrayHasKey('user', $decodedResponse);
    }
}
