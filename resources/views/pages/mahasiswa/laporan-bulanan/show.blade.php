@extends('layouts.mahasiswa.app')

@section('title', 'Laporan Kemajuan')

@section('styles')
  <link rel="stylesheet" href="{{ url('assets/vendor/libs/quill/typography.css') }}" />
  <link rel="stylesheet" href="{{ url('assets/vendor/libs/quill/katex.css') }}" />
  <link rel="stylesheet" href="{{ url('assets/vendor/libs/quill/editor.css') }}" />
@endsection

@section('content')

  <div class="col-lg-12 mb-4 h-100">
    <div class="card mb-3">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          {!! $status[$laporanBulanan->status] !!}
          <h2 class="my-2">Detail Laporan Kemajuan Bulanan</h2>
          <small class="text-muted">Detail laporan kemajuan bulanan, harap isi laporan kemajuan bulanan setiap
            awal bulan dari tanggal 1 sampai 10</small>
        </div>
      </div>
      <div class="card-body">
        <div class="row">

        </div>
      </div>
    </div>

    {{-- card form --}}
    <div class="card">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h3 class="mb-2">Isi Laporan Bulanan pada <span
              class="badge bg-label-success mx-0 px-3 rounded-3 small">{{ $laporanBulanan->created_at->format('d-m-Y') }}</span>
          </h3>
          <small class="text-muted">Berikut adalah detail laporan kemajuan bulanan anda</small>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group mb-3">
              <label for="judul">Judul Laporan</label>
              <input type="text" class="form-control" id="judul" rows="3" placeholder="Judul Laporan"
                value="{{ $laporanBulanan->judul }}" readonly>
            </div>
            <div class="form-group mb-3">
              <label for="judul">Isi Laporan Progress</label>
              <div class="border  rounded-3 p-3 mb-3" id="laporan">

              </div>
            </div>
            {{-- komentar promotor --}}
            <div class="form-group mb-3">
              <label for="judul">Komentar Promotor</label>
              <div class="border  rounded-3 p-3 mb-3" id="k1">
                {!! $laporanBulanan->komentar_promotor ?? '' !!}
              </div>
            </div>
            {{--  komentar co-promotor 1 --}}
            <div class="form-group mb-3">
              <label for="judul">Komentar Co-Promotor 1</label>
              <div class="border  rounded-3 p-3 mb-3" id="k2">
                {!! $laporanBulanan->komentar_co_promotor1 ?? '' !!}
              </div>
            </div>
            {{--  komentar co-promotor 2 --}}
            @if (Auth::user()->co_promootor2_id)
              <div class="form-group mb-3">
              <label for="judul">Komentar Co-Promotor 2</label>
              <div class="border  rounded-3 p-3 mb-3" id="k3">
                {!! $laporanBulanan->komentar_co_promotor2 ?? '' !!}
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {

      // initailize quill
      var laporan = new Quill('#laporan', {
        theme: 'bubble',
        readOnly: true,
      });

      // set quill content
      laporan.setContents({!! $laporanBulanan->isi_progress !!});

      // initailize quill
      var k1 = new Quill('#k1', {
        theme: 'bubble',
        readOnly: true,
      });

      // set quill content
      k1.setContents({!! $laporanBulanan->komentar_promotor !!});

      // initailize quill
      var k2 = new Quill('#k2', {
        theme: 'bubble',
        readOnly: true,
      });

      // set quill content
      k2.setContents({!! $laporanBulanan->komentar_co_promotor1 !!});
@if (Auth::user()->co_promootor2_id)
      // initailize quill
      var k3 = new Quill('#k3', {
        theme: 'bubble',
        readOnly: true,
      });

      // set quill content
      k3.setContents({!! $laporanBulanan->komentar_co_promotor2 !!});
@endif
    });
  </script>
@endsection
