@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')


<div class="attendance__content">

<div class="date-nav">
  <a href="{{ $preDate ? route('showByDate', ['date' => $preDate]) : '#' }}" class="{{ $preDate ? '' : 'disabled' }}">
    <button class="btn btn-outline-primary" {{ $preDate ? '' : 'disabled'}}>
      &lt;
    </button>
  </a>
</div>

<span>{{ $date }}</span>

<div class="date-nav">
  <a href="{{ $nextDate ? route('showByDate', ['date' => $nextDate]) : '#' }}" class="{{ $nextDate ? '' : 'disabled' }}">
    <button class="btn btn-outline-primary" {{ $nextDate ? '' : 'disabled'}}>
      &gt;
    </button>
  </a>

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
          <td>
            @if ($attendance->breakTimes->isNotEmpty())
              {{ $attendance->total_break_time }}
            @else
              休憩なし
            @endif
          </td>
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

<div class="d-flex justify-content-center">
    {{ $attendances->appends(['date' => $date])->links() }}
</div>

<footer>
  <p>Atte, inc</p>
</footer>

@endsection
</html>