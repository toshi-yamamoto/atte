@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<main?>
<div class="register__content">
  <div class="register-form__heading">
    <h2>会員登録</h2>
  </div>
  <form class="form" action="/register" method="post">
    @csrf
    <div class="form__group">
      <div class="form__group-title">
        <!-- <span class="form__label--item">お名前</span> -->
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="text" name="name" value="{{ old('name') }}" placeholder="お名前"/>
        </div>
        <div class="form__error">
          @error('name')
          {{ $message }}
          @enderror
        </div>
      </div>
    </div>
    <div class="form__group">
      <div class="form__group-title">
        <!-- <span class="form__label--item">メールアドレス</span> -->
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス"/>
        </div>
        <div class="form__error">
          @error('email')
          {{ $message }}
          @enderror
        </div>
      </div>
    </div>
    <div class="form__group">
      <div class="form__group-title">
        <!-- <span class="form__label--item">パスワード</span> -->
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="password" name="password" placeholder="パスワード"/>
        </div>
        <div class="form__error">
          @error('password')
          {{ $message }}
          @enderror
        </div>
      </div>
    </div>
    <div class="form__group">
      <div class="form__group-title">
        <!-- <span class="form__label--item">確認用パスワード</span> -->
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="password" name="password_confirmation" placeholder="確認用パスワード"/>
        </div>
      </div>
    </div>
    <div class="form__button">
      <button class="form__button-submit" type="submit">登録</button>
    </div>
  </form>
  <div class="login__link">
    <p>アカウントをお持ちの方はこちらから</p>
    <a class="login__button-submit" href="/login">ログイン</a>
  </div>
</div>
</main>
<footer>
  <p>Atte, inc</p>
</footer>
@endsection