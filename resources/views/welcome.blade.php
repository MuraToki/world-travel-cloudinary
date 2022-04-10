<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="">
  

<main class="log-regi">
    <div class="text-center ">
        @if (Route::has('login'))
            @auth
            <div class="wel-btn my-4">
                <a href="{{ url('/home') }}" class="btn btn-dark">一覧画面に戻る</a>
            </div>

            @else
            <div class="wel-btn my-4">
                <a href="{{ route('login') }}" class="btn btn-dark">ログイン</a>
            </div>
            
            @if (Route::has('register'))
            <div class="wel-btn my-4">
                <a href="{{ route('register') }}" class="btn btn-dark">新規登録</a>
            </div>
            @endif
            <div class="wel-btn my-4">
                <a href="{{ route('login.guest') }}" class="btn btn-dark">ゲストログイン</a>
            </div>
            @endauth
            @endif
    </div>


</div>
</main>

</body>
</head>