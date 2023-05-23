<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateBookTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->postJson('/api/book/store',
            [
                'isbn' => '202020202',
                'title' => 'titre 1',
                'author' => 'Auteur 1',
                'editor' => 'Editeur 1',
                'isAvailable' => 1,
                'formatId' => 1,
                'userId' => 1
            ]
        );

        $response->assertStatus(201)->assertJson(['created' => true]);
    }
}
