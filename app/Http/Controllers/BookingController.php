<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        // 
        // \DB::table('bookings')->get()->dd();

        // Получение всех записей, включая удалённые при SoftDeletes
        // Booking::withTrashed()->get()->dd();

        // получение всех записей из таблицы БД
        // $bookings = DB::table('bookings')->get();

        // получение всех записей из БД с пагинацией;        
        // with('room') просит дозагрузить все связанные данные таблицы rooms,
        // используется для жадной загрузки (запросить всё, что можно)
        // Варианты для жадной загрузки (Eager_loading):
        // with('room')
        // with('room.roomType')
        // with(['room.roomType', 'users'])
        // with(['room.roomType', 'users:name'])
        
        $bookings = Booking::with(['room.roomType', 'users:name'])->paginate(1);
       // $bookings = Booking::paginate(1);

        // передача переменной во вью не с помощью массива, а с помощью with()
        return view('bookings.index')
            ->with('bookings', $bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('none');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');

        // подправил временный баг с переходом на /bookings/create: 
        // объект $booking вшит во вью fields.blade.php 
        // и вью без $booking не работает
        $booking = new Booking();

        return view('bookings.create')
            ->with('users', $users)
            ->with('rooms', $rooms)
            
            ->with('booking', $booking);
            // можно так, без предварительной переменной $booking:
            //->with('booking', (new Booking()) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //dd($request->input('room_id'));
        //dd($request);
        // Позволяет играть с отправкой POST
        // dd($request->all());

        // Здесь ловятся значения из формы.
        // Вставка значений в таблицу bookings 
        // и получение идентификатора. 
        // Вместо этого блока кода можно написать одну срочку ниже.
        /*
        $id = DB::table('bookings')->insertGetId([
            'room_id' => $request->input('room_id'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            // значение по умолчанию false
            'is_reservation' => $request->input('is_reservation', false),
            // значение по умолчанию false
            'is_paid' => $request->input('is_paid', false),
            'notes' => $request->input('notes'),
        ]);
        */

        $booking = Booking::create($request->input());

        // Вставка значений в таблицу bookings_users 

        // Заменим эти строчки на следующие, чтобы использовать отношения,
        // получаемые от разных таблиц
        /*
        DB::table('bookings_users')->insert([
            'booking_id' => $booking->id,
            'user_id' => $request->input('user_id'),
        ]);
        */
        $booking->users()->attach($request->input('user_id'));
        //$user = $booking->users()->create(['name' => 'test']);


        // Редирект
        return redirect()->action('BookingController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        // Понимание $booking,
        // отображается на "/bookings/1"
        // согласно маршруту bookings.show
        // dd($booking);
        

        // Получение всех атрибутов в массиве из объекта $booking
        //   dd($booking->getAttributes());
        // Получение единичных данных из объекта $booking
        //   dd($booking->room_id, $booking->notes);

        // По факту передали объект во вью,
        // где можно обращаться к его свойствам
        return view('bookings.show', ['booking' => $booking]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('none');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');
        $bookingsUser = DB::table('bookings_users')->where('booking_id', $booking->id)->first();
        return view('bookings.edit')
            ->with('users', $users)
            ->with('rooms', $rooms)
            ->with('booking', $booking)
            ->with('bookingsUser', $bookingsUser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        /*
        // Две строчки ниже вместо этого

        DB::table('bookings')
        ->where('id', $booking->id)
        ->update([
            'room_id' => $request->input('room_id'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            // значение по умолчанию false
            'is_reservation' => $request->input('is_reservation', false),
            // значение по умолчанию false
            'is_paid' => $request->input('is_paid', false),
            'notes' => $request->input('notes'),
        ]);
        */

        $booking->fill($request->input());
        $booking->save();

        // Заменим эти строчки на следующие, чтобы использовать отношения,
        // получаемые от разных таблиц.
        /*
        // Вставка значений в таблицу bookings_users 
        DB::table('bookings_users')
        ->where('booking_id', $booking->id)        
        ->update([
            // booking_id при update не нужно обновлять
            // 'booking_id' => $booking->id,
            'user_id' => $request->input('user_id'),
        ]);
        */
        $booking->users()->sync([$request->input('user_id')]);
        
        // Редирект
        return redirect()->action('BookingController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        // Заменим эту строчку на следующую, чтобы использовать отношения,
        // получаемые от разных таблиц.
        /*
        DB::table('bookings_users')->where('booking_id', $booking->id)->delete();
       */
       $booking->users()->detach();


       // Вместо этой строчки будет задействована модель Booking
       // одной строчкой ниже
       // DB::table('bookings')->where('id', $booking->id)->delete();
       $booking->delete();
       
       return redirect()->action('BookingController@index');
    }
}
