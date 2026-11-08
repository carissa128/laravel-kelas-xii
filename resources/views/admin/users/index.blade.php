@extends('templates.index')

@section('content')
<div class="container">
  <h2>Daftar User</h2>
  <p><a class="btn btn-default" href="{{ route('admin.dashboard') }}">Dashboard admin</a></p>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr><th>Nama</th><th>Email</th><th>Role</th><th>Umur</th><th>Alamat</th><th>Terdaftar</th></tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role?->name ?? '-' }}</td>
            <td>{{ $user->profile?->umur ?? '-' }}</td>
            <td>{{ $user->profile?->alamat ?? '-' }}</td>
            <td>{{ $user->created_at?->format('d-m-Y') }}</td>
          </tr>
        @empty
          <tr><td colspan="6">Belum ada user.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $users->links() }}
</div>
@endsection
