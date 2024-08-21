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
          <form class="attendance__button" action="{{ route('startWork') }}" method="post">
            @csrf
            <td><button class="attendance__button-submit" type="submit" >勤務開始</button></td>
          </form>
          <form class="attendance__button" action="{{ route('endWork') }}" method="post">
            @csrf
            <td><button class="attendance__button-submit" type="submit">勤務終了</button></td>
          </form>
        </tr>
        <tr>
          <form class="attendance__button" action="{{ route('startBreak') }}" method="post">
            @csrf
            <td><button class="attendance__button-submit" type="submit">休憩開始</button></td>
          </form>
          <form class="attendance__button" action="{{ route('endBreak') }}" method="post">
            @csrf
            <td><button class="attendance__button-submit" type="submit">休憩終了</button></td>
          </form>
        </tr>
      </table>
    </div>
</div>

<footer>
  <p>Atte, inc</p>
</footer>
@endsection