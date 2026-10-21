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
  <link rel="stylesheet" href="{{ asset('css/hci.css') }}">
  <script src="{{ asset('js/theme.js') }}"></script>
</head>
<body>
  <header class="nav no-print">
    <a href="{{ route('home') }}" class="logo">Portfolia</a>
    <nav>
      <a href="{{ route('home') }}">Home</a>
      @auth
        <a href="{{ route('portfolios.create') }}">Create</a>
        <a href="{{ route('portfolios.index') }}">Manage</a>
        <form method="POST" action="{{ route('logout') }}" class="navform" data-confirm="Are you sure you want to log out?" data-confirm-title="Log out?">
          @csrf
          <button type="submit" class="btn ghost sm">Log out</button>
        </form>
      @else
        <a href="{{ route('login') }}">Log in</a>
        <a class="btn sm" href="{{ route('register') }}">Sign up</a>
      @endauth
    </nav>
  </header>

  <main>@yield('content')</main>

  <div id="toast" role="status" aria-live="polite">{{ session('status') }}</div>
  <dialog id="confirm-dialog" class="confirm-dialog" aria-labelledby="confirm-title" aria-describedby="confirm-message">
    <form method="dialog" class="confirm-panel">
      <h2 id="confirm-title">Please confirm</h2>
      <p id="confirm-message">Are you sure?</p>
      <div class="end">
        <button type="button" class="btn ghost" id="confirm-cancel">Cancel</button>
        <button type="button" class="btn danger" id="confirm-accept">Confirm</button>
      </div>
    </form>
  </dialog>
  <script>
    (function () {
      var t = document.getElementById("toast");
      if (t && t.textContent.trim()) {
        t.classList.add("show");
        setTimeout(function () { t.classList.remove("show"); }, 4500);
      }

      var dialog = document.getElementById('confirm-dialog');
      var title = document.getElementById('confirm-title');
      var message = document.getElementById('confirm-message');
      var cancel = document.getElementById('confirm-cancel');
      var accept = document.getElementById('confirm-accept');
      var pendingForm = null;
      document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (form.dataset.confirmed === 'yes') {
            form.dataset.confirmed = 'no';
            return;
          }
          event.preventDefault();
          pendingForm = form;
          title.textContent = form.dataset.confirmTitle || 'Please confirm';
          message.textContent = form.dataset.confirm || 'Are you sure you want to continue?';
          accept.textContent = form.dataset.confirmTitle === 'Log out?' ? 'Log out' : 'Yes, continue';
          if (typeof dialog.showModal === 'function') dialog.showModal();
          else if (window.confirm(message.textContent)) {
            form.dataset.confirmed = 'yes';
            form.requestSubmit();
          }
        });
      });
      cancel.addEventListener('click', function () { pendingForm = null; dialog.close(); });
      accept.addEventListener('click', function () {
        if (!pendingForm) return;
        var form = pendingForm;
        pendingForm = null;
        dialog.close();
        form.dataset.confirmed = 'yes';
        form.requestSubmit();
      });
      dialog.addEventListener('click', function (event) {
        if (event.target === dialog) { pendingForm = null; dialog.close(); }
      });

      document.querySelectorAll('.copy-link').forEach(function (button) {
        button.addEventListener('click', async function () {
          var input = document.getElementById(button.dataset.target);
          if (!input) return;
          try {
            await navigator.clipboard.writeText(input.value);
            button.textContent = 'Copied!';
          } catch (error) {
            input.focus(); input.select();
            button.textContent = 'Copy selected link';
          }
          window.setTimeout(function () { button.textContent = 'Copy link'; }, 2200);
        });
      });
    })();
  </script>
  <script src="{{ asset('js/background.js') }}"></script>
</body>
</html>
