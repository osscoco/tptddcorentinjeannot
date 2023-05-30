<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function Termwind\ValueObjects\getValue;

class CreateBookTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->postJson('/api/login',
            [
                'email' => 'corentin.jeannot2a@gmail.com',
                'password' => 'Not24get'
            ]
        )->assertStatus(200);

        $JWTtoken = $response->decodeResponseJson()["token"];

        $response1 = $this->withHeaders(['Authorization' => 'Bearer ' . $JWTtoken ])->postJson('/api/book/store',
            [
                'isbn' => '2490334166',
                'title' => 'titre 1',
                'author' => 'Auteur 1',
                'editor' => 'Editeur 1',
                'isAvailable' => 1,
                'formatId' => 1,
                'userId' => 1
            ]
        );

        $response1->assertStatus(200)->assertJson(['status' => true]);
    }
}
