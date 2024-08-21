@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')


<div class="attendance__content">

<table>
  <tr>
    <th>名前</th>
    <th>勤務開始</th>
    <th>勤務終了</th>
    <th>休憩時間</th>
    <th>勤務時間</th>
  </tr>

    @foreach ($attendances as $attendance)
      <tr>
          <td>{{ $attendance->user->name }}</td>
          <td>{{ \Carbon\Carbon::parse($attendance->work_start_time)->format('H:i:s') }}</td>
          <td>
            @if ($attendance->work_end_time)
              {{ \Carbon\Carbon::parse($attendance->work_end_time)->format('H:i:s') }}
            @else
              未登録
            @endif
          </td>
          <td>休憩時間合計</td>
          <td>
            @if ($attendance->work_end_time)
            {{ \Carbon\Carbon::parse($attendance->work_start_time)->diff(\Carbon\Carbon::parse($attendance->work_end_time))->format('%H:%i:%s')}}
            @else
              未登録
            @endif
          </td>
      </tr>
    @endforeach

</table>
</div>

<footer>
  <p>Atte, inc</p>
</footer>

@endsection
</html>