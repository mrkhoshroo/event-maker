<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test for entire login and registration process.
     * @group register
     * @return void
     */
    public function testRegistration()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->image('sample_picture.jpg')->size(5000);;

        $response = $this->json(
            'POST',
            '/api/auth/signup',
            [
                'name' => 'default',
                'email' => 'default2@sample.com',
                'phone_number' => '09223456789',
                'picture' => $file,
                'password' => 'secretsecret',
                'password_confirmation' => 'secretsecret',
            ]

        );

        $response->dump();

        $response
            ->assertStatus(200);


        $accessToken = json_decode((string) $response->getContent(), true)['token'];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('api/auth/getuser');

        $response->dump();

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'default',
                'email' => 'default2@sample.com',
                'phone_number' => '09223456789',
            ]);


        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('api/auth/logout');

        $response->dump();
    }

    public function testLogin()
    {
        $response = $this->json(
            'POST',
            '/api/auth/signup',
            [
                'name' => 'default',
                'email' => 'default2@sample.com',
                'phone_number' => '09223456789',
                'password' => 'secretsecret',
                'password_confirmation' => 'secretsecret',
            ]

        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            // 'Authorization' => 'Bearer ' . $accessToken,
        ])->get('api/auth/getuser');

        $response->dump();

        $response->assertUnauthorized();

        $response = $this->json(
            'POST',
            '/api/auth/login',
            [
                'user_name' => '09223456789',
                'password' => 'secretsecret',
            ]

        );

        $response->dump();

        $response
            ->assertStatus(200);

        $accessToken = json_decode((string) $response->getContent(), true)['token'];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('api/auth/getuser');

        $response->dump();

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'default',
                'email' => 'default2@sample.com',
                'phone_number' => '09223456789',
            ]);
    }
}
