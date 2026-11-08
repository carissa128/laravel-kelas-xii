@extends('templates.index')

@section('content')
<div class="container">
  <h2>{{ $title }}</h2>
  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  @endif
  <form action="{{ route($action, $item->exists ? $item : []) }}" method="post">
    @csrf
    @if ($method !== 'POST')
      @method($method)
    @endif
    @foreach ($fields as $field)
      @php($value = old($field['name'], data_get($item, $field['name'])))
      <div class="form-group">
        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
        @if ($field['type'] === 'textarea')
          <textarea class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}" required>{{ $value }}</textarea>
        @elseif ($field['type'] === 'select')
          <select class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}" required>
            <option value="">Pilih {{ strtolower($field['label']) }}</option>
            @foreach ($field['options'] as $optionValue => $optionLabel)
              <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
            @endforeach
          </select>
        @else
          <input class="form-control" type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" value="{{ $value }}" required>
        @endif
      </div>
    @endforeach
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a class="btn btn-default" href="{{ route($resourceRoute.'.index') }}">Batal</a>
  </form>
</div>
@endsection
