<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_comment() {
        $formData = [
            'name' => 'Jeremiah Malicdem',
            'comment' => 'Test Comment',
            'parent_id' => null,
        ];

        $this->withoutExceptionHandling();
        $this->json('POST', '/api/comments', $formData)
             ->assertStatus(201);
    }

    public function test_should_not_save_when_name_has_special_characters() {
        $formData = [
            'name' => 'Test J**3nz',
            'comment' => 'Test Comment',
            'parent_id' => null,
        ];

        $this->withExceptionHandling();
        $response = $this->json('POST', '/api/comments', $formData);
        $response->assertStatus(422);
    }

    public function test_can_retrieve_results() {
        $this->json('GET', '/api/comments')->assertStatus(200);
    }
}
