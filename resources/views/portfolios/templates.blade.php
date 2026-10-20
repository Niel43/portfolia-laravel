@extends('layouts.app')
@section('title', 'Choose template')
@section('content')
@php
  $options = [
    ['simple', 'Simple', 'Clean single column that is easy to read.'],
    ['modern', 'Modern', 'Cards, sections, and a timeline.'],
    ['creative', 'Creative', 'Bold split screen with a dark theme.'],
  ];
@endphp
  <section class="wrap">
    <h1>Choose a template</h1>
    <p class="sub">Your information is saved. Pick how your portfolio should look.</p>
    <div class="cards3">
      @foreach ($options as [$key, $name, $desc])
        <div class="card-box">
          <div class="th th-{{ $key }}"><i></i><b></b><b></b><b></b><b></b></div>
          <h3>{{ $name }}</h3>
          <p class="sub">{{ $desc }}</p>
          <form method="POST" action="{{ route('portfolios.setTemplate', $portfolio) }}" class="plain">
            @csrf
            @method('PUT')
            <input type="hidden" name="template" value="{{ $key }}">
            <button class="btn">Use {{ $name }}</button>
          </form>
        </div>
      @endforeach
    </div>
  </section>
@endsection
