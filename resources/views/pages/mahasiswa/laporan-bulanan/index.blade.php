@extends('layouts.mahasiswa.app')

@section('title', 'Laporan Kemajuan')

@section('styles')

@endsection

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="card mb-3">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h2 class="mb-2">Laporan Kemajuan Bulanan</h2>
          <small class="text-muted">Proses pengajuan laporan kemajuan bulanan, harap isi laporan kemajuan bulanan setiap
            awal bulan dari tanggal 1 sampai 10</small>
        </div>
      </div>
      <div class="card-body">
        <div class="row">

        </div>
      </div>
    </div>

    @if (!$status)
      <div class="alert alert-warning d-flex align-items-center" role="alert">
        <i class="ti ti-exclamation-circle me-1 fw-bold"></i> <strong class="me-2">Perhatian!</strong> Pengajuan Laporan Bulanan sedang ditutup, harap mengajukan laporan kemajuan bulanan pada tanggal 1 sampai 10
          setiap bulannya.
      </div>
    @endif
    <div class="row">
      <div class="col-lg-12">
        @include('components.datatable', [
            'search_text' => 'Cari Laporan...',
            'table' => $dataTable,
            'button_create' => $status ? route('laporan-bulanan.create') : null,
        ])
      </div>
    </div>
  </div>
@endsection

@section('scripts')

@endsection
