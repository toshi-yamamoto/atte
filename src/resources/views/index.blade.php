@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="attendance__content">
  <div class="attendance__content-message">{{ $user->name }}さんお疲れ様です！</div>
  <br>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div><br>
  @endif
    <div class="attendance__panel">
        <table>
        <tr>
        <form class="attendance__button" action="/start" method="post">
          @csrf
          <td><button class="attendance__button-submit" type="submit" >勤務開始</button></td>
        </form>
        <form class="attendance__button" action="/end" method="post">
          @csrf
          <td><button class="attendance__button-submit" type="submit">勤務終了</button></td>
        </form>
        </tr>
        <tr>
          <td><button class="attendance__button-submit" type="submit">休憩開始</button></td>
          <td><button class="attendance__button-submit" type="submit">休憩終了</button></td>
        </tr>
      </table>
        </form>
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