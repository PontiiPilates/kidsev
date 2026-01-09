<!doctype html>
<html lang="ru">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title')</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  {{-- End Bootstrap --}}

  {{-- Jquerry --}}
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  {{-- End Jquerry --}}

</head>

<body>

  {{-- Navigation --}}
  <nav class="navbar navbar-dark navbar-expand-lg bg-dark mb-5">
    <div class="container">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link @if( url()->current() == route('admin.home') ) active @endif" aria-current="page" href="{{ route('admin.home') }}">Главная</a></li>
          <li class="nav-item"><a class="nav-link @if( url()->current() == route('admin.programs.index') ) active @endif" aria-current="page" href="{{ route('admin.programs.index') }}">Программы и расписание</a></li>
          <li class="nav-item"><a class="nav-link @if( url()->current() == route('admin.events.index') ) active @endif" aria-current="page" href="{{ route('admin.events.index') }}">Мероприятия и расписание</a></li>
          <li class="nav-item"><a class="nav-link @if( url()->current() == route('admin.promotions.index') ) active @endif" aria-current="page" href="{{ route('admin.promotions.index') }}">Акции</a></li>
          <li class="nav-item"><a class="nav-link @if( url()->current() == route('admin.about.index') ) active @endif" aria-current="page" href="{{ route('admin.about.index') }}">Адреса и контакты</a></li>
        </ul>
      </div>
    </div>
  </nav>
  {{-- End Navigation --}}

  {{-- Content --}}
  <div class="container">
    @yield('content')
  </div>
  {{-- End Content --}}

  {{-- Syles --}}
  <style>
    .interaction-shadow:hover {
      -webkit-box-shadow: 0px 0px 12px 0px rgba(34, 60, 80, 0.12);
      -moz-box-shadow: 0px 0px 12px 0px rgba(34, 60, 80, 0.12);
      box-shadow: 0px 0px 12px 0px rgba(34, 60, 80, 0.12);
    }
  </style>
  {{-- End Syles --}}

  {{-- Bootstrap --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  {{-- End Bootstrap --}}

</body>

</html>