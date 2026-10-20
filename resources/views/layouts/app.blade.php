<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Portfolia') | Portfolia</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Lora:wght@400;600&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="{{ asset('js/theme.js') }}"></script>
</head>
<body>
  <header class="nav">
    <a href="{{ route('home') }}" class="logo">Portfolia</a>
    <nav>
      <a href="{{ route('home') }}">Home</a>
      @auth
        <a href="{{ route('portfolios.create') }}">Create</a>
        <a href="{{ route('portfolios.index') }}">Manage</a>
        <form method="POST" action="{{ route('logout') }}" class="navform">
          @csrf
          <button class="btn ghost sm">Log out</button>
        </form>
      @else
        <a href="{{ route('login') }}">Log in</a>
        <a class="btn sm" href="{{ route('register') }}">Sign up</a>
      @endauth
    </nav>
  </header>

  <main>@yield('content')</main>

  <div id="toast" role="status" aria-live="polite">{{ session('status') }}</div>
  <script>
    (function () {
      var t = document.getElementById("toast");
      if (t.textContent.trim()) {
        t.classList.add("show");
        setTimeout(function () { t.classList.remove("show"); }, 3500);
      }
    })();
  </script>
  <script src="{{ asset('js/background.js') }}"></script>
</body>
</html>
