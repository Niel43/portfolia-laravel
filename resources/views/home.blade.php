@extends('layouts.app')
@section('title', 'Home')
@section('content')
  <section class="hero">
    <h1>Portfolia</h1>
    <p>Create an account, enter your details once, save them online, and turn them into a portfolio with one of three templates.</p>
    <a class="btn" href="{{ route('portfolios.create') }}">Create portfolio</a>
    @auth
      <a class="btn ghost" href="{{ route('portfolios.index') }}">Manage portfolios</a>
    @else
      <a class="btn ghost" href="{{ route('login') }}">Log in</a>
    @endauth
  </section>
@endsection
