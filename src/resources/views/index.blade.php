@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<!-- <div class="attendance__alert">
  // メッセージ機能
</div> -->

<div class="attendance__content">
  <div class="attendance__content-message">xxxxさんお疲れ様です！</div>
  <br>

    <div class="attendance__panel">
      <table>
        <form class="attendance__button" action="/attendances" method="post">
          @csrf
          <tr>
          <input type="hidden" name="work_start_time" value="1111-11-11 11:11:11">
          <button class="attendance__button-submit" type="submit" >勤務開始</button>
          <button class="attendance__button-submit" type="submit">勤務終了</button>
          </tr>
          <button class="attendance__button-submit" type="submit">休憩開始</button>
          <button class="attendance__button-submit" type="submit">休憩終了</button>
        </form>
      </table>
    </div>

</div>

  <!-- <div class="attendance-table">
    <table class="attendance-table__inner">
      <tr class="attendance-table__row">
        <th class="attendance-table__header">名前</th>
        <th class="attendance-table__header">開始時間</th>
        <th class="attendance-table__header">終了時間</th>
      </tr>
      <tr class="attendance-table__row">
        <td class="attendance-table__item">サンプル太郎</td>
        <td class="attendance-table__item">サンプル</td>
        <td class="attendance-table__item">サンプル</td>
      </tr>
    </table>
  </div> -->
</div>
<footer>
  <p>Atte, inc</p>
</footer>
@endsection