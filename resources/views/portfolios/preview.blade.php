@extends('layouts.app')
@section('title', $portfolio->full_name)
@section('content')
  <div class="bar no-print">
    <a class="btn ghost sm" href="{{ route('portfolios.edit', $portfolio) }}">Edit information</a>
    <a class="btn ghost sm" href="{{ route('portfolios.templates', $portfolio) }}">Change template</a>
    <a class="btn sm" href="{{ route('portfolios.index') }}">Manage portfolios</a>
  </div>
  <section class="wrap no-print">
    <h2>Your portfolio is ready, {{ $portfolio->full_name }}!</h2>
    <p class="sub">Share this public link with anyone you want to view your portfolio. Anyone with the link can see the information shown below.</p>
    <div class="public-link">
      <label for="share-link">Your public portfolio URL</label>
      <input id="share-link" readonly value="{{ route('portfolios.public', $portfolio->public_id) }}">
      <button type="button" class="btn" id="copy-share-link">Copy link</button>
      <a class="btn ghost" href="{{ route('portfolios.public', $portfolio->public_id) }}" target="_blank" rel="noopener">Open public page</a>
    </div>
    <p id="share-feedback" class="help-text" role="status" aria-live="polite"></p>
    <div class="public-actions">
      <button type="button" class="btn ghost" onclick="window.print()">Download PDF / Print</button>
    </div>
  </section>
  @include('templates.' . $tpl, ['p' => $portfolio])
  <script>
    (function () {
      var button = document.getElementById('copy-share-link');
      var input = document.getElementById('share-link');
      var feedback = document.getElementById('share-feedback');
      if (!button || !input || !feedback) return;
      button.addEventListener('click', async function () {
        try {
          await navigator.clipboard.writeText(input.value);
          feedback.textContent = 'Link copied. You can now share it with others.';
        } catch (error) {
          input.focus();
          input.select();
          feedback.textContent = 'Your browser could not copy automatically. The link is selected so you can copy it manually.';
        }
      });
    })();
  </script>
@endsection
