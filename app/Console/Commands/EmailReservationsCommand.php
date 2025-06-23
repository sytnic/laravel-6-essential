<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailReservationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'reservations:notify 
    {count : The number of bookings to retrieve}';

    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'Notify reservations holders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Создаётся числовой аргумент для своей команды в protected $signature,
        // с валидацией (проверкой) на число.
        $count = $this->argument('count');
        if (!is_numeric($count)) {
            $this->alert('The count must be a number');            
            return 1;
            // это классический возврат для консоли,
            // показывающий состояние программы, что именно вернулось;
            // обычно использовали 0 для успешного состояния,
            // и любое другое для идентификации ошибок.
        }
        
        // Информационная строка
        $bookings = \App\Booking::with(['room.roomType','users'])->limit($count)->get();
        $this->info(sprintf('The number of bookings to alert for is: %d', $bookings->count()));

        // Прогресс-бар
        $bar = $this->output->CreateProgressBar($bookings->count());
        $bar->start();
        foreach($bookings as $booking){
            $this->error('Nothing happened');
            $bar->advance();
        }
        $bar->finish();
        $this->comment('Command completed!');
    }
}
