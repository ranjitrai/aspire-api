<?php

namespace Tests\Feature;

use App\Loan;
use Laravel\Passport\Passport;
use Tests\TestCase;


class AcceptLoanTest extends TestCase
{

    public function __construct()
    {
         parent::__construct();
    }


    /**
     * accept loan  api validation test.
     *
     */
    public function test_it_validates_input_for_accept_loan()
    {
           $user = \App\User::create([
                'email' => 'ranjit@example.com',
                'name' => 'ranjit',
                'password' => bcrypt('123456789qq')
            ]);

            $loan = \App\Loan::create([
                'amount' => 10000,
                'term' => 1,
                'user_id' =>$user->id
            ]);
            Passport::actingAs($user);
            $response = $this->postJson('/api/accept-loan', [
                // 'loan_id' => $loan->id
            ]);
            $decodedResponse = json_decode($response->getContent(), true);
            $this->assertArrayHasKey('errors', $decodedResponse);
    }

    /**
     * Loan accept api validation test.
     *
     */
    public function test_it_accept_loan_()
    {       
            $user = \App\User::create([
                'email' => 'ranjit@example.com',
                'name' => 'ranjit',
                'password' => bcrypt('123456789qq')
            ]);

            $loan = \App\Loan::create([
                'amount' => 10000,
                'term' => 1,
                'user_id' =>$user->id
            ]);
            Passport::actingAs($user);
            $response = $this->postJson('/api/accept-loan', [
                'loan_id' => $loan->id
            ]);
            $response->assertStatus(200);
            $decodedResponse = json_decode($response->getContent(), true);
            $this->assertArrayHasKey('status', $decodedResponse);
    }
}
