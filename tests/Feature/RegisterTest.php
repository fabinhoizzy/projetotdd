<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_be_able_to_register_as_a_new_user()
    {

        // arrange



        // Act

        $return = $this->post(route('register'), [
           'name' => 'Fabio Silva',
           'email' => 'fabio@teste.com',
           'email_confirmation' => 'fabio@teste.com',
           'password' => 'uma senha qualquer',
        ]);

        // Assert

        $return->assertRedirect('dashboard');

        $this->assertDatabaseHas('users', [
           'name' => 'Fabio Silva',
           'email' => 'fabio@teste.com',
        ]);

        /** @var User $user */
        $user = User::whereEmail('fabio@teste.com')->firstOrFail();

        $this->assertTrue(
            Hash::check('uma senha qualquer', $user->password),
            'Checking if password was saved it is encrypted'
        );

        $this->assertAuthenticatedAs($user);
    }
}
