<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- asset() was used before mix--}}
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <script src="{{mix('js/app.js')}}" defer></script>
    <title>Laravel App - @yield('title')</title>
</head>
<body>
<div>
    @if(session('status'))
        <div style="background: red; color: white">
            {{session('status')}}
        </div>
    @endif
    @yield('content')
</div>
</body>
</html>
