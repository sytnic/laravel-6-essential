<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowRoomsControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        // проверяемый url
        $response = $this->get('/test');

        // проверяемые ожидаемые данные
        $response->assertStatus(200)
            ->assertSeeText('Goodbye');
    }
}
