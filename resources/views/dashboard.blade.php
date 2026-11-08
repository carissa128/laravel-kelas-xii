@extends('templates.index')

@section('content')
<div class="container">
  <h2>Dashboard</h2>
  <p>Halo, {{ $user->name }}. Dari sini kamu bisa mengelola profil dan melihat komentar yang pernah dikirim.</p>
  <p><a class="btn btn-primary" href="{{ route('profile.show') }}">Lihat / ubah profil</a></p>
  <h3>Komentar saya ({{ $commentCount }})</h3>
  @forelse ($comments as $comment)
    <div class="panel panel-default">
      <div class="panel-heading">
        @if ($comment->film)
          <a href="{{ route('movies.show', $comment->film) }}">{{ $comment->film->title }}</a>
        @else
          Film sudah tidak tersedia
        @endif
        — Rating {{ $comment->rating }}/5
      </div>
      <div class="panel-body">{{ $comment->comment }}</div>
    </div>
  @empty
    <p>Kamu belum memberi komentar. <a href="{{ route('movies') }}">Cari film untuk dikomentari</a>.</p>
  @endforelse
  <a href="{{ route('movies') }}">Lihat semua film</a>
</div>
@endsection
