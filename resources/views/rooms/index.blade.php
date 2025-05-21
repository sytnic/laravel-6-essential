@extends('layouts.app')

@section('content')
<table class="table">
	<thead>
		<tr>
			<th>
				Room Number
			</th>
			<th>
				Type
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($rooms as $room)  {{-- переменная $rooms из ShowRoomsController --}}
			<tr>
				<td>{{ $room->number }}</td>
			{{-- обращение к полю room_type_id текущей таблицы room без отношений Eloquent --}}
			{{--	<td>{{ $room->room_type_id }}</td>  --}} 
			{{-- обращение к полю name другой таблицы room_types на основе отношений Eloquent, Lazy-loading --}}
			     <td>{{ $room->roomType->name }}</td> 
			</tr>
		@endforeach
	</tbody>
</table>
@endsection