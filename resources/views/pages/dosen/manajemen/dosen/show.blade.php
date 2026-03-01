@extends('layouts.dosen.app')

@section('title', 'Data dosen')

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="d-flex align-items-center mb-3">
      <a href="#" class="btn btn-icon me-2 btn-primary" onClick="window.history.back();">
        <i class="ti ti-chevron-left"></i>
      </a>
      <div class="ms-3">
        <h4 class="card-header-title mb-0">
          Data {{ $dosen->nama }}
        </h4>
        <p class="mb-0 text-muted">{{ $dosen->nama }} - {{ $dosen->no_induk }}</p>
      </div>
    </div>

    <div class="row gap-3 gap-lg-0">
      <div class="col-lg-4">
        <div class="d-grid gap-3">
          <div class="card">
            <div class="card-header mb-0 pb-0">
              <h4 class="card-header-title">Data Dosen</h4>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-start align-items-center mb-3">
                <div class="avatar avatar-xl me-4">
                  <img class="rounded" src="{{ UserHelper::getDosenPicture($dosen->no_induk) }}" alt="Foto"
                    onerror="onImageErrorGuest(this)" style="object-fit: cover; aspect-ratio: 1/1; object-position: top;">
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>Nama Lengkap</b></p>
                <p class="mb-0">{{ $dosen->nama }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>NIK/NIP/NIDN</b></p>
                <p class="mb-0">{{ $dosen->no_induk }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
          <div class="card mb-3">
            <div class="card-header">
              <h4 class="card-header-title">Data dosen</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Nama</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $dosen->nama }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>NIK/NIP/NIDN</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $dosen->no_induk }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Email</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $dosen->email }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Pangkat/gol</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $dosen->pangkat_gol }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Role</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $dosen->role }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Terakhir Diubah</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $dosen->updated_at }} ({{ $dosen->updated_at->diffForHumans() }})</p>
                  </div>
                </div>
              </div>
            </div>
          </div>


      </div>
    </div>
  </div>
@endsection

