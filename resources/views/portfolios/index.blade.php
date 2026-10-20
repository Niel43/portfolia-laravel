@extends('layouts.app')
@section('title', 'Manage portfolios')
@section('content')
  <section class="wrap">
    <div class="head">
      <h1>Manage portfolios</h1>
      <a class="btn" href="{{ route('portfolios.create') }}">New portfolio</a>
    </div>

    @forelse ($portfolios as $p)
      <div class="card-box mrow">
        @include('templates._photo')
        <div class="grow">
          <b>{{ $p->full_name }}</b>
          <div class="sub">{{ $p->email }} &middot; {{ ucfirst($p->template ?? 'simple') }} template</div>
        </div>
        <div class="acts">
          <a class="btn ghost sm" href="{{ route('portfolios.preview', $p) }}">View</a>
          <a class="btn ghost sm" href="{{ route('portfolios.edit', $p) }}">Edit</a>
          <form method="POST" action="{{ route('portfolios.destroy', $p) }}" class="plain"
                onsubmit="return confirm('Delete this portfolio? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <button class="btn danger sm">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div class="card-box empty">
        <h3>Start your first portfolio</h3>
        <p class="sub">Add your details and pick a template.</p>
        <a class="btn" href="{{ route('portfolios.create') }}">Create portfolio</a>
      </div>
    @endforelse
  </section>
@endsection
