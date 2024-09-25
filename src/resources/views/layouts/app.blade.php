<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
  @yield('css')
</head>

<body>
  <header class="header">
    <nav class="navbar navbar-expand-lg" style="background-color: #fffff">
        <span class="navbar-brand h1">Atte</span>
          <ul class="navbar-nav ms-auto">
            @if (Auth::check())
            <li class="nav-item active">
              <a class="nav-link" href="/login">ホーム</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">日付一覧</a>
            </li>
            <li class="nav-item active">
              <form class="form" action="/logout" method="post">
                @csrf
                <button type="button" class="btn btn-link text-decoration-none">ログアウト</button>
              </form>
            </li>
            @endif
          </ul>
        </nav>
      </div>
</nav>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>