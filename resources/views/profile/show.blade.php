@extends('templates.index')

@section('content')
<div class="container">
  <h2>Profil Saya</h2>
  @if (session('status'))
    <p class="alert alert-success" role="status">{{ session('status') }}</p>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  @endif
  <form action="{{ route('profile.update') }}" method="post">
    @csrf
    @method('put')
    <div class="form-group">
      <label for="name">Nama</label>
      <input class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="255">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255">
    </div>
    <div class="form-group">
      <label for="umur">Umur</label>
      <input class="form-control" type="number" id="umur" name="umur" value="{{ old('umur', $user->profile->umur) }}" min="1" max="120" required>
    </div>
    <div class="form-group">
      <label for="bio">Bio</label>
      <textarea class="form-control" id="bio" name="bio" maxlength="1000" required>{{ old('bio', $user->profile->bio) }}</textarea>
    </div>
    <div class="form-group">
      <label for="alamat">Alamat</label>
      <textarea class="form-control" id="alamat" name="alamat" maxlength="1000" required>{{ old('alamat', $user->profile->alamat) }}</textarea>
    </div>
    <button class="btn btn-primary" type="submit">Simpan profil</button>
    <a class="btn btn-default" href="{{ route('dashboard') }}">Kembali ke dashboard</a>
  </form>
</div>
@endsection
