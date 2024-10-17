@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')

<div class="container-fluid text-center">
  <h5 class="pb-5">{{ $currentUserId->name }}さんお疲れ様です！</h5>
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
    <div class="row">
        <div class="col-md-6 mb-3">
          <form class="attendance__button" action="{{ route('startWork') }}" method="post">
            @csrf
              <button class="btn btn-primary btn-lg w-100 mb-3 custom-button" type="submit"
                @if ($disableStartWorkButton) disabled @endif>
                勤務開始
              </button>
          </form>
        </div>

        <div class="col-md-6 mb-3">
          <form class="attendance__button" action="{{ route('endWork') }}" method="post">
            @csrf
              <button class="btn btn-primary btn-lg w-100 mb-3 custom-button" type="submit"
              @if ($disableEndWorkButton) disabled @endif>
              勤務終了
            </button>
          </form>
        </div>

        <div class="col-md-6 mb-3">
          <form class="attendance__button" action="{{ route('startBreak') }}" method="post">
            @csrf
              <button class="btn btn-primary btn-lg w-100 mb-3 custom-button" type="submit"
            @if ($disableStartBreakButton) disabled @endif>
            休憩開始
          </button></td>
          </form>
          </div>

          <div class="col-md-6 mb-3">
          <form class="attendance__button" action="{{ route('endBreak') }}" method="post">
            @csrf
            <button class="btn btn-primary btn-lg w-100 mb-3 custom-button" type="submit"
            @if ($disableEndBreakButton) disabled @endif>
              休憩終了
            </button></td>
          </form>
          </div>
    </div>
</div>

  <div class="footer">
    <p>Atte, inc.</p>
  </div>

@endsection