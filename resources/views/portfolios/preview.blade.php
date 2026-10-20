@extends('layouts.app')
@section('title', $portfolio->full_name)
@section('content')
  <div class="bar">
    <a class="btn ghost sm" href="{{ route('portfolios.edit', $portfolio) }}">Edit information</a>
    <a class="btn ghost sm" href="{{ route('portfolios.templates', $portfolio) }}">Change template</a>
    <a class="btn sm" href="{{ route('portfolios.index') }}">Manage portfolios</a>
  </div>
  @include('templates.' . $tpl, ['p' => $portfolio])
@endsection
