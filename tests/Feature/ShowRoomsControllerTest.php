<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ShowRoomsControllerTest extends TestCase
{
    // При каждом новом тесте обновлять фейковую БД, когда используешь ее
    use RefreshDatabase;
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

    /**
     * Тест для проверки, что когда мы указываем Тип номера в Factory,
     * мы перечисляем номера комнат, которые соответствуют этому конкретному Типу.
     */
    public function  testRoomParameter()
    {
        // Создать 3 случайные записи Типа номеров в БД
        $roomTypes = factory('App\RoomType', 3)->create();
        // Создать 20 случайных записей номеров комнат в БД
        $rooms = factory('App\Room', 20)->create();

        // Выбрать случайный id Типа комнаты
        $roomType = $roomTypes->random();

        // Тест
        $response = $this->get('/rooms/'. $roomType->id);

        $response->assertStatus(200)
        ->assertSeeText('Type')
        ->assertViewIs('rooms.index')
        ->assertViewHas('rooms')
        ->assertSeeText($roomType->name);       
    }

    /**
     * Тестирование загрузки файла на несуществующем файле
     */
    public function testUpdateFile()
    {
        // создание фейкового файла
        $file = UploadedFile::fake()->image('sample.jpg');
        // создание типа команты
        $roomType = factory('App\RoomType')->create();
        // тестовая отправка файла с формой;
        // в других случаях можно использовать this->post и this->delete
        $response = $this->put("/room_types/{$roomType->id}",
            ['picture' => $file]
        );

        // проверка теста,
        // проверка успешности редиректа
        $response->assertStatus(302)
            ->assertRedirect('/room_types');
        // проверка успешного сохранения файла в хранилище
        Storage::disk('public')->assertExists($file->hashName());
    }
}
