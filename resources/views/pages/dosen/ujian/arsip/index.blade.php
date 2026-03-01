@extends('layouts.dosen.app')

@section('title', 'Ujian Tertutup Disertasi')

@section('styles')

@endsection

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="card mb-3">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h2 class="mb-2">Arsip Ujian Disertasi</h2>
          <small class="text-muted">Halaman ini berisi data mahasiswa yang telah mengikuti ujian disertasi</small>
        </div>
      </div>
      <div class="card-body">
        <div class="row">

        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        @include('components.datatable', [
            'search_text' => 'Cari Mahasiwa...',
            'table' => $dataTable,
        ])
      </div>
    </div>


  </div>
@endsection

@section('scripts')

@endsection
