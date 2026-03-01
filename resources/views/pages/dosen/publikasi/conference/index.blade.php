@extends('layouts.dosen.app')

@section('title', 'Publikasi Conference')

@section('content')
  <div class="mb-4">
    <h2 class="mb-1">
      <b>Publikasi Conference</b>
    </h2>
    <span class="text-muted">
      Anda dapat melihat publikasi conference mahasiswa yang sudah diunggah.
    </span>
  </div>

  @if (Session::has('berhasil'))
    <div class="alert alert-success mt-2 mb-4">
      {{ Session::get('berhasil') }}
    </div>
    {{-- else --}}
  @elseif (Session::has('gagal'))
    <div class="alert alert-danger mt-2 mb-4">
      {{ Session::get('gagal') }}
  @endif


  @include('components.datatable', [
      'search_text' => 'Cari publikasi...',
      'table' => $dataTable,
  ])

@endsection
