@extends('layouts.app')
@section('title', 'Manage portfolios')
@section('content')
  <section class="wrap">
    <div class="head">
      <div>
        <h1>Manage portfolios</h1>
        <p class="sub">View, update, share, or remove your portfolios.</p>
      </div>
      <a class="btn" href="{{ route('portfolios.create') }}">Create portfolio</a>
    </div>

    @forelse ($portfolios as $p)
      <div class="card-box mrow">
        @include('templates._photo')
        <div class="grow">
          <b>{{ $p->full_name }}</b>
          <div class="sub">{{ $p->email ?: 'No email added' }} &middot; {{ ucfirst($p->template ?? 'simple') }} template</div>
          @if ($p->public_id)
            <div class="public-link">
              <label for="public-link-{{ $p->id }}">Shareable portfolio link</label>
              <input id="public-link-{{ $p->id }}" readonly value="{{ route('portfolios.public', $p->public_id) }}" aria-label="Public portfolio link">
              <button type="button" class="btn ghost sm copy-link" data-target="public-link-{{ $p->id }}">Copy link</button>
            </div>
          @endif
        </div>
        <div class="acts">
          <a class="btn ghost sm" href="{{ route('portfolios.preview', $p) }}">Preview</a>
          @if ($p->public_id)<a class="btn ghost sm" href="{{ route('portfolios.public', $p->public_id) }}" target="_blank" rel="noopener">Public view</a>@endif
          <a class="btn ghost sm" href="{{ route('portfolios.edit', $p) }}">Edit</a>
          <form method="POST" action="{{ route('portfolios.destroy', $p) }}" class="plain" data-confirm="Are you sure you want to delete this portfolio? This action cannot be undone." data-confirm-title="Delete portfolio?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn danger sm">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div class="card-box empty">
        <h3>Your portfolio journey starts here</h3>
        <p class="sub">Add your details, choose a template, then share your public link.</p>
        <a class="btn" href="{{ route('portfolios.create') }}">Create your first portfolio</a>
      </div>
    @endforelse
  </section>
@endsection
