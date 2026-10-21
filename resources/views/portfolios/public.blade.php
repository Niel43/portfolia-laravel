@extends('layouts.app')
@section('title', $portfolio->full_name . ' — Portfolio')
@section('content')
  <div class="public-actions no-print" aria-label="Portfolio actions">
    <button type="button" class="btn" onclick="window.print()">Download PDF / Print</button>
    <button type="button" class="btn ghost" id="copy-public-link" data-link="{{ url()->current() }}">Copy portfolio link</button>
  </div>
  <p id="copy-feedback" class="status-note no-print" role="status" aria-live="polite" hidden></p>
  @include('templates.' . $tpl, ['p' => $portfolio])
  <script>
    (function () {
      var button = document.getElementById('copy-public-link');
      var feedback = document.getElementById('copy-feedback');
      if (!button || !feedback) return;
      button.addEventListener('click', async function () {
        var link = button.dataset.link;
        try {
          await navigator.clipboard.writeText(link);
          feedback.textContent = 'Portfolio link copied. You can now share it with others.';
        } catch (error) {
          feedback.textContent = 'Copy was blocked by your browser. Copy this link from the address bar: ' + link;
        }
        feedback.hidden = false;
      });
    })();
  </script>
@endsection
