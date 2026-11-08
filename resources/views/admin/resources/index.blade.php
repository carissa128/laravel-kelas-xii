@extends('templates.index')

@section('content')
<div class="container">
  <h2>Kelola {{ $title }}</h2>
  <p>
    <a class="btn btn-primary" href="{{ route($resourceRoute.'.create') }}">Tambah {{ strtolower($title) }}</a>
    <a class="btn btn-default" href="{{ route('admin.dashboard') }}">Dashboard admin</a>
  </p>
  @if (session('status'))
    <p class="alert alert-success" role="status">{{ session('status') }}</p>
  @endif
  @if ($errors->has('delete'))
    <p class="alert alert-danger" role="alert">{{ $errors->first('delete') }}</p>
  @endif
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          @foreach ($columns as $label)
            <th>{{ $label }}</th>
          @endforeach
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($items as $item)
          <tr>
            @foreach ($columns as $key => $label)
              <td>{{ data_get($item, $key) }}</td>
            @endforeach
            <td>
              <a class="btn btn-default btn-sm" href="{{ route($resourceRoute.'.edit', $item) }}">Ubah</a>
              <form action="{{ route($resourceRoute.'.destroy', $item) }}" method="post" style="display:inline">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="{{ count($columns) + 1 }}">Belum ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $items->links() }}
</div>
@endsection
