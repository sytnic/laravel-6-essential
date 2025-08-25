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
        $response = $this->get('/rooms');

        // проверяемые ожидаемые данные
            // проверка ответа 200
        $response->assertStatus(200)
            // ожидаемый текст
            ->assertSeeText('Type')
            // ожидаемое Вью
            ->assertViewIs('rooms.index')
            // ожидаемые переменные Вью
            ->assertViewHas('rooms');
    }
}
