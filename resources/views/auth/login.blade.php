@extends('layouts.app')
@section('title', 'Log in')
@section('content')
  <section class="wrap narrow">
    <h1>Log in</h1>
    <p class="sub">Welcome back. Log in to manage your portfolios.</p>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
      @error('email')<div class="err">{{ $message }}</div>@enderror

      <label for="password">Password</label>
      <input id="password" type="password" name="password" required autocomplete="current-password">
      @error('password')<div class="err">{{ $message }}</div>@enderror

      <div class="check">
        <input id="remember" type="checkbox" name="remember" value="1">
        <label for="remember">Keep me logged in</label>
      </div>

      <div class="end"><button class="btn">Log in</button></div>
    </form>
    <p class="sub center" style="margin-top:18px">New here? <a href="{{ route('register') }}">Create an account</a></p>
  </section>
@endsection
