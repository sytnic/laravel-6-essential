<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailReservationsCommandTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        // $this->assertTrue(true);

        // Проверяем в методе 
        // app\Console\Commands\EmailReservationsCommand@processBooking()
        // его условие if, вызовы функций и их параметры

        $notify = $this->getMockBuilder('App\Libraries\Notifications')
            ->disableOriginalConstructor()
            ->setMethods(['send'])
            ->getMock();
        $notify->expects($this->once())
            ->method('send')
            ->with()
            ->willReturn(true);

        $command = $this->getMockBuilder('App\Console\Commands\EmailReservationsCommand')
            ->setConstructorArgs([$notify])
            ->setMethods(['option'])
            ->getMock();
        $command->expects($this->once())
            ->method('option')
            ->with('dry-run')
            ->willReturn(false);
        $command->processBooking();
    }
}
