<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    // Настройка для повторного обновления БД
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        // Создать пользователя
        $user = factory('App\User')->create();
        // Пользователь, вошедший в систему, входит в приложение
        $response = $this->actingAs($user)->get('/home');

        // Проверки
        $response->assertStatus(200)
            // видимый текст
            ->assertSeeText('You are logged in');
    }

    public function testLoggedOut()
    {        
        // Пользователь, не вошедший в систему, входит в приложение
        $response = $this->get('/home');

        // Проверки
        $response->assertStatus(302)
            // редирект
            ->assertRedirect('/login');
    }
}
