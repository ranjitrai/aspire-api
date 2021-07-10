<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;


class LoanRepaymentTest extends TestCase
{

    public function __construct()
    {
         parent::__construct();
    }

    /**
     * Loan repayment api validation test.
     *
     */
    public function test_it_validates_input_for_loan_repayment()
    {
            $user = \App\User::create([
                'email' => 'ranjit@example.com',
                'name' => 'ranjit',
                'password' => bcrypt('123456789qq')
            ]);
            Passport::actingAs($user);
            $loan = \App\Loan::create([
                'amount' => 10000,
                'term' => 1,
                'user_id' =>$user->id
            ]);
            $response = $this->postJson('/api/loan-repayment', [
                // 'amount' => 1500, amount not passed
                'loan_id' => $loan->id
            ]);
            $decodedResponse = json_decode($response->getContent(), true);
            $this->assertArrayHasKey('errors', $decodedResponse);
    }

    /**
     * Loan apply test.
     *
     */
    public function test_it_loan_repayment()
    {
        $user = \App\User::create([
                'email' => 'ranjit@example.com',
                'name' => 'ranjit',
                'password' => bcrypt('123456789qq')
            ]);

            Passport::actingAs($user);
            $loan = \App\Loan::create([
                'amount' => 10000,
                'term' => 1,
                'user_id' =>$user->id
            ]);

            $response = $this->postJson('/api/accept-loan', [
                'loan_id' => $loan->id
            ]);
            $response = $this->getJson('/api/loan-repayment-amount/' . $loan->id);
            $decodedResponse = json_decode($response->getContent(), true);
            $response = $this->postJson('/api/loan-repayment', [
                'loan_id' => $loan->id,
                'amount' => $decodedResponse['amount']
            ]);
            $response->assertStatus(200);
            $decodedResponse = json_decode($response->getContent(), true);
            $this->assertArrayHasKey('status', $decodedResponse);
    }
}
