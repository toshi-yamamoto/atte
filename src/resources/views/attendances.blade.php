@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')

<div class="container-fluid text-center">
  <a href="{{ $preDate ? route('showByDate', ['date' => $preDate]) : '#' }}" class="{{ $preDate ? '' : 'disabled' }}">
    <button class="btn btn-outline-primary btn-light" {{ $preDate ? '' : 'disabled'}}>&lt;</button>
  </a>
<span>{{ $date }}</span><span> </span>
  <a href="{{ $nextDate ? route('showByDate', ['date' => $nextDate]) : '#' }}" class="{{ $nextDate ? '' : 'disabled' }}">
    <button class="btn btn-outline-primary btn-light" {{ $nextDate ? '' : 'disabled'}}>&gt;</button>
  </a>
<br><br><br>
<table class="table table-striped table-hover attendance-table">
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
<br><br>
<div class="d-flex justify-content-center">
    {{ $attendances->appends(['date' => $date])->onEachSide(3)->links('vendor.pagination.bootstrap-4') }}
</div>

</div>

  <div class="footer">
    <p>Atte, inc.</p>
  </div>

@endsection