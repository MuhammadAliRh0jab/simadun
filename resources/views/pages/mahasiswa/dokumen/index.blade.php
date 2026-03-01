@extends('layouts.mahasiswa.app')

@section('title', 'Dokumen')

@section('content')
  <div class="mb-4">
    <h2 class="mb-1">
      <b>Dokumen</b>
    </h2>
    <span class="text-muted">
      Anda dapat mengakses dokumen-dokumen petunjuk teknis pada halaman ini.
    </span>
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
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection
