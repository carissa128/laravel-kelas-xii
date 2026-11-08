@extends('templates.index')

@section('content')
<div class="container">
  <h2>Dashboard Administrator</h2>
  <p>Kelola data aplikasi dari menu berikut.</p>
  <ul class="nav nav-pills">
    <li><a href="{{ route('admin.films.index') }}">Kelola film ({{ $filmCount }})</a></li>
    <li><a href="{{ route('admin.casts.index') }}">Kelola cast ({{ $castCount }})</a></li>
    <li><a href="{{ route('admin.genres.index') }}">Kelola genre ({{ $genreCount }})</a></li>
    <li><a href="{{ route('admin.perans.index') }}">Kelola peran ({{ $peranCount }})</a></li>
    <li><a href="{{ route('admin.users.index') }}">Data user ({{ $userCount }})</a></li>
  </ul>
</div>
@endsection
