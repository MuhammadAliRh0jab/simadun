@extends('layouts.dosen.app')

@section('title', 'Publikasi Jurnal')

@section('content')
  <div class="mb-4">
    <h2 class="mb-1">
      <b>Publikasi Jurnal</b>
    </h2>
    <span class="text-muted">
      Anda dapat melihat publikasi jurnal mahasiswa yang sudah diunggah.
    </span>
  </div>


  @include('components.datatable', [
      'search_text' => 'Cari publikasi...',
      'table' => $dataTable,
  ])

@endsection
