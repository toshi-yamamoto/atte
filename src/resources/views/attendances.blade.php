@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')

<div class="container text-center">
  <a href="{{ $preDate ? route('showByDate', ['date' => $preDate]) : '#' }}" class="{{ $preDate ? '' : 'disabled' }}">
    <button class="btn btn-outline-primary" {{ $preDate ? '' : 'disabled'}}>&lt;</button>
  </a>
<span>{{ $date }}</span>
  <a href="{{ $nextDate ? route('showByDate', ['date' => $nextDate]) : '#' }}" class="{{ $nextDate ? '' : 'disabled' }}">
    <button class="btn btn-outline-primary" {{ $nextDate ? '' : 'disabled'}}>&gt;</button>
  </a>

<table class="table">
  <thead>
  <tr>
    <th scope="col">名前</th>
    <th scope="col">勤務開始</th>
    <th scope="col">勤務終了</th>
    <th scope="col">休憩時間</th>
    <th scope="col">勤務時間</th>
  </tr>
</thead>
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

<div class="d-flex justify-content-center">
    {{ $attendances->appends(['date' => $date])->onEachSide(3)->links('vendor.pagination.bootstrap-4') }}
</div>

<footer class="footer">
    <p>Atte, inc</p>
</footer>
</div>
@endsection
</html>