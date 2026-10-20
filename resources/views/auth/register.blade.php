@extends('layouts.app')
@section('title', 'Sign up')
@section('content')
  <section class="wrap narrow">
    <h1>Create account</h1>
    <p class="sub">Sign up to build and manage your portfolios.</p>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <label for="name">Name</label>
      <input id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
      @error('name')<div class="err">{{ $message }}</div>@enderror

      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
      @error('email')<div class="err">{{ $message }}</div>@enderror

      <label for="password">Password (at least 8 characters)</label>
      <input id="password" type="password" name="password" required autocomplete="new-password">
      @error('password')<div class="err">{{ $message }}</div>@enderror

      <label for="password_confirmation">Confirm password</label>
      <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">

      <div class="end"><button class="btn">Create account</button></div>
    </form>
    <p class="sub center" style="margin-top:18px">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
  </section>
@endsection
