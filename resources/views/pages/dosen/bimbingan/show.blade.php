@extends('layouts.dosen.app')

@section('title', 'Mahasiswa Bimbingan')

@section('styles')

@endsection

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="d-flex align-items-center mb-3">
      <a href="#" class="btn btn-icon me-2 btn-primary" onClick="window.history.back();">
        <i class="ti ti-chevron-left"></i>
      </a>
      <div class="ms-3">
        <h4 class="card-header-title mb-0">
          Mahasiswa Bimbingan
        </h4>
        <p class="mb-0 text-muted">{{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}</p>
      </div>
    </div>

    <div class="row gap-3 gap-lg-0">
      <div class="col-lg-4">
        <div class="d-grid gap-3">
          <div class="card">
            <div class="card-header mb-0 pb-0">
              <h4 class="card-header-title">Data Mahasiswa</h4>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-start align-items-center mb-3">
                <div class="avatar avatar-xl me-4">
                  <img class="rounded" src="{{ UserHelper::getMahasiswaPicture($mahasiswa->nim) }}" alt="Foto"
                    onerror="onImageErrorGuest(this)" style="object-fit: cover; aspect-ratio: 1/1;">
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>Nama Lengkap</b></p>
                <p class="mb-0">{{ $mahasiswa->nama }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>NIM</b></p>
                <p class="mb-0">{{ $mahasiswa->nim }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>Promotor</b></p>
                <p class="mb-0">{{ $mahasiswa->promotor1 }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>CO-Promotor 1</b></p>
                <p class="mb-0">{{ $mahasiswa->promotor2 }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>CO-Promotor 2</b></p>
                <p class="mb-0">{{ $mahasiswa->promotor3 }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="d-grid gap-3 mt-3">
          <div class="card">
            <div class="card-header mb-0 pb-0">
              <h4 class="card-header-title">Progress Ujian</h4>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="form-label col-7 mb-0"><b>Ujian Proposal</b></p>
                <div class="col-5">
                  <p class="mb-0">
                    @if ($ujian->proposal)
                      <span class="badge bg-success">Sudah</span>
                    @else
                      <span class="badge bg-danger">Belum</span>
                    @endif
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label col-7 mb-0"><b>Ujian Seminar Hasil</b></p>
                <div class="col-5">
                  <p class="mb-0">
                    @if ($ujian->semhas)
                      <span class="badge bg-success">Sudah</span>
                    @else
                      <span class="badge bg-danger">Belum</span>
                    @endif
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0 col-7"><b>Ujian Publikasi</b></p>
                <div class="col-5">
                  <p class="mb-0">
                    @if ($ujian->semhas)
                      <span class="badge bg-success">Sudah</span>
                    @else
                      <span class="badge bg-danger">Belum</span>
                    @endif
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0 col-7"><b>Ujian Disertasi</b></p>
                <div class="col-5">
                  <p class="mb-0">
                    @if ($ujian->semhas)
                      <span class="badge bg-success">Sudah</span>
                    @else
                      <span class="badge bg-danger">Belum</span>
                    @endif
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0 col-7"><b>Ujian Tertutup</b></p>
                <div class="col-5">
                  <p class="mb-0">
                    @if ($ujian->semhas)
                      <span class="badge bg-success">Sudah</span>
                    @else
                      <span class="badge bg-danger">Belum</span>
                    @endif
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-lg-8">
        @if ($detail)
          <div class="card mb-3">
            <div class="card-header">
              <h4 class="card-header-title">Data Detail Mahasiswa</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>No HP</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->no_hp }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Email um</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->email_um }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Email lain</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->email_lain }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Alamat Malang</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->alamat_malang }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Alamat Asal</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->alamat_asal }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>PT S1</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->PT_S1 }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>PT S2</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->PT_S2 }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Skor TOEFL</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->skor_toefl }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Skor TPA</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->skor_TPA }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Terakhir Diubah</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $detail->updated_at }} ({{ $detail->updated_at->diffForHumans() }})</p>
                  </div>
                </div>

              </div>
            </div>
          </div>
        @endif

        <div class="card">
          <div class="card-header">
            <h4 class="card-header-title">Data Ujian Mahasiswa</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Judul Naskah</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $mahasiswa->judul }}</p>
                </div>
              </div>

              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Naskah Ujian Proposal</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    <a href="{{ $ujian->proposal ?? '' }}" target="_blank" rel="noopener noreferrer">
                      <p class="mb-0" id="naskah">{{ $ujian->proposal ?? '' }}</p>
                    </a>
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Naskah Ujian Seminar Hasil</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    <a href="{{ $ujian->semhas ?? '' }}" target="_blank" rel="noopener noreferrer">
                      <p class="mb-0" id="naskah">{{ $ujian->semhas ?? '' }}</p>
                    </a>
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Naskah Ujian Publikasi</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    <a href="" target="_blank" rel="noopener noreferrer">
                      <p class="mb-0" id="naskah">{{ $ujian->publikasi ?? '' }}</p>
                    </a>
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Naskah Ujian Disertasi</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    <a href="{{ $ujian->disertasi ?? '' }}" target="_blank" rel="noopener noreferrer">
                      <p class="mb-0" id="naskah">{{ $ujian->disertasi ?? '' }}</p>
                    </a>
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Naskah Ujian Tertutup</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    <a href="{{  route('file', ['filename' => $ujian->tertutup ?? 'null']) }}" target="_blank" rel="noopener noreferrer">
                      <p class="mb-0" id="naskah">{{ $ujian->tertutup ?? '' }}</p>
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>



      </div>
    </div>
  </div>
@endsection

@section('scripts')

@endsection
