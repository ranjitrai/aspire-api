<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;


class ApplyLoanTest extends TestCase
{

   

    public function __construct()
    {
         parent::__construct();
    }


    /**
     * Loan apply api validation test.
     *
     */
    public function test_it_validates_input_for_apply_loan()
    {
            $user = \App\User::create([
                'email' => 'ranjit@example.com',
                'name' => 'ranjit',
                'password' => bcrypt('123456789qq')
            ]);
            Passport::actingAs($user);
            $response = $this->postJson('/api/apply-loan', [
                // 'amount' => 10000, amount not passed
                'term' => 6,
                'user_id' => $user->id
            ]);
            $decodedResponse = json_decode($response->getContent(), true);
            $this->assertArrayHasKey('errors', $decodedResponse);
    }

    /**
     * Loan apply test.
     *
     */
    public function test_it_apply_loan()
    {
        $user = \App\User::create([
            'email' => 'ranjit@example.com',
            'name' => 'ranjit',
            'password' => bcrypt('123456789qq')
        ]);
        Passport::actingAs($user);
        $response = $this->postJson('/api/apply-loan', [
            'amount' => 10000,
            'term' => 6,
            'user_id' => $user->id
        ]);
        $response->assertStatus(200);
    }
}
