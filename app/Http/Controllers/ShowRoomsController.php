<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ShowRoomsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $roomType = null)
    {
        /*
        // вывод на экран простейшей строки
        // return response('A listing of rooms', 200);

        // Работа без модели через DB
        // $rooms = DB::table('rooms')->get();

        // Работа с пустой моделью Room (равнозначна работе с DB)
        $rooms = Room::get();

        //  если в запросе указан id (он не null)
        if ($request->query('id') !== null) {
            // то перезаписываем $rooms только теми, у которых room_type_id	== id из запроса
            $rooms = $rooms->where('room_type_id', $request->query('id'));
        }

        // вывод на экран всех комнат из БД в формате JSON
        // вывод на экран, минуя вью
        //return response()->json($rooms);

        */
        
        /* Этот блок заменён на обращение к модели Room ниже
        if (isset($roomType)) {
            $rooms = Room::where('room_type_id', "!=", $roomType)->get();
        } else {
            $rooms = Room::get();
        }
        */

        $rooms = Room::byType($roomType)->get();
        // или возможная расширенная вариация
        // $rooms = Room::byType($roomType)->withTrashed()->where()->get();

        // вывод на экран через вью
        return view('rooms.index', ['rooms' => $rooms]);
        // rooms.index  - вью
        // 'rooms' -  будущая переменная во вью
        // $rooms  -  локальная переменная здесь
    }
}
