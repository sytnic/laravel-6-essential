<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facades\App\Libraries\Notifications;

class EmailReservationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // команда для artisan
    //protected $signature = 'command:name';

    // команда для artisan - reservations:notify,
    // {count} - аргумент команды,
    // {--dry-run} - опция команды,
    // после двоеточия { : } - подписи аргумента и опции.
    protected $signature = 'reservations:notify     
    {count : The number of bookings to retrieve}
    {--dry-run= : To have this command do no actual work.}';

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
        // $answer = $this->ask('What service should we use?');
        // var_dump($answer);

        // $answer = $this->anticipate('What service should we use?', ['sms', 'email']);
        // var_dump($answer);

        $answer = $this->choice(
            'What service should we use?', 
            ['sms', 'email'],
            // опция, которая будет использована по умолчанию:
            'email'
        );
        var_dump($answer);

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
        $bar = $this->output->createProgressBar($bookings->count());  
        //$bar->setOverwrite(false);      

        $bar->start();    

        foreach($bookings as $booking){

        // обработка опции
          if ($this->option('dry-run')) {
              $this->info(' Would process booking');
              
          } else {
              //$this->error(' Nothing happened'); 
              
              // $this->notify->send();
              Notifications::send();
          }

          // замечено, что эта строчка $bar->advance() не отрабатывает в консоли Docker'a
          $bar->advance();
        }  
        
        $bar->finish();          
        
        $this->comment(' Command completed!');            
    }
}