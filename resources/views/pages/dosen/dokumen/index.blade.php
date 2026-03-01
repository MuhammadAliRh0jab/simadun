@extends('layouts.dosen.app')

@section('title', 'Dokumen')

@section('content')
<div class="row mb-4">
  <div class="col-sm-8">
    <h2 class="mb-1"><strong>Dokumen</strong></h2>
    <p class="text-muted">
      Anda dapat mengakses dokumen-dokumen petunjuk teknis pada halaman ini.
    </p>
  </div>
  <div class="col-sm-4 text-sm-end">
    @if (UserHelper::isKaprodi())
    <a class="btn btn-success" href="{{ route('dokumen.create') }}">+ Add Document</a>
    @endif
  </div>
</div>

<div class="card">
  <div class="card-body">
    <table class="table table-striped rounded-4">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Dokumen</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dokumen as $index => $file)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $file->judul }}</td>
          <td>
            <a href="{{ asset('files/' . $file->filename) }}" class="btn btn-primary" target="_blank">Download</a>

            @if (UserHelper::isKaprodi())
            <form action="{{ route('dokumen.destroy', $file->id) }}" method="POST" class="delete_record" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger delete-btn">Hapus</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection