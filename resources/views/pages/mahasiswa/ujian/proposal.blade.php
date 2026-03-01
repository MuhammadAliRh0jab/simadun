@extends('layouts.mahasiswa.app')
@section('title', 'Seminar Proposal')

@section('content')
<div class="col-lg-12 mb-4 h-100" id="ujian_proposan">
  <div class="card mb-3">
    <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
      <div class="card-title mb-3">
        <h2 class="mb-2">Ujian Seminar Proposal</h2>
        <small class="text-muted">Proses Ujian Seminar Proposal. Tahap ini terdiri dari 4 tahapan utama yaitu
          pendaftaran, konfirmasi, status, dan finalisasi ujian. Harap mengikuti tahapan sesuai dengan petunjuk yang
          diberikan</small>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <ul class="step step-md">
          <li class="step-item">
            <div class="step-content-wrapper">
              <span steps="0" class="step-icon step-icon-soft-primary">1</span>
              <div class="step-content">
                <h4 class="step-title">Pendaftaran</h4>
                <p class="step-text">Upload berkas dan pengajuan penguji</p>
              </div>
            </div>
          </li>
          <li class="step-item">
            <div class="step-content-wrapper">
              <span steps="1" class="step-icon step-icon-soft-secondary">2</span>
              <div class="step-content">
                <h4 class="step-title">Konfirmasi</h4>
                <p class="step-text">Konfirmasi pendaftaran ujian</p>
              </div>
            </div>
          </li>
          <li class="step-item">
            <div class="step-content-wrapper">
              <span steps="2" class="step-icon step-icon-soft-secondary">3</span>
              <div class="step-content">
                <h4 class="step-title">Status</h4>
                <p class="step-text">Status Pendaftaran</p>
              </div>
            </div>
          </li>
          <li class="step-item">
            <div class="step-content-wrapper">
              <span steps="4" class="step-icon step-icon-soft-secondary">4</span>
              <div class="step-content">
                <h4 class="step-title">Finalisasi Ujian</h4>
                <p class="step-text">Finalisasi dan revisi naskah</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="card d-none" data-step="0">
    <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
      <div class="card-title mb-3">
        <h3 class="mb-2">Form Pendaftaran</h3>
        <small class="text-muted">Harap isi form pendaftaran dengan benar</small>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          <form action="{{ route('ujian.proposal.store') }}" method="post" id="pendaftaran">
            @csrf
            {{-- nama nim --}}
            <div class="form-group row mb-3">
              <div class="col-12 col-md-6">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <input type="text" class="form-control" name="nama" value="{{ Auth::user()->nama }}" readonly>
                <div class="form-text">Nama dan NIM diambil otomatis dari data mahasiswa</div>
              </div>
              <div class="col-12 col-md-6">
                <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                <input type="text" class="form-control" name="nim" value="{{ Auth::user()->nim }}" readonly>
              </div>
            </div>
            {{-- usulan penguji --}}
            <div class="form-group mb-3">
              <label for="usulan_penguji" class="form-label">Usulan Penguji</label>
              <select class="form-select @error('usulan_penguji') is-invalid @enderror" multiple="multiple"
                id="dosen_search" name="usulan_penguji[]" data-search-dosen-url="{{ route('search.dosen') }}"
                data-csrf-token="{{ csrf_token() }}" required>
                @if ($proposal)
                  <option value="{{ $proposal->penguji1_id ?? '' }}" selected>
                    {{ $proposal->usulan_penguji1 ?? '' }}
                  </option>
                  <option value="{{ $proposal->penguji2_id ?? '' }}" selected>
                    {{ $proposal->usulan_penguji2 ?? '' }}
                  </option>
                  @if ($proposal->penguji3_id)
                    <option value="{{ $proposal->penguji3_id }}" selected>
                      {{ $proposal->usulan_penguji3 ?? '' }}
                    </option>
                  @endif
                @endif
              </select>
              <div class="form-text">Silahkan mengajukan minimal 2 dosen sebagai penguji (maksimal 3 dosen).</div>
              @error('usulan_penguji')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            {{-- link gdrive naskah --}}
            <div class="form-group mb-3">
              <label for="naskah" class="form-label">Link Google Drive Naskah</label>
              <input type="url" class="form-control naskah @error('naskah') is-invalid @enderror" name="naskah"
                value="{{ old('naskah', $proposal->file ?? '') }}" placeholder="Masukkan link GDrive naskah" required>
              @error('naskah')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text err" id="err">Pastikan link/url Google Drive naskah dapat diakses</div>
            </div>
            {{-- submit --}}
            <div class="form-group mb-3 text-end">
              <button type="submit" class="btn btn-primary btn-next" id="pendaftaran_submit">
                <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Selanjutnya</span>
                <i class="ti ti-arrow-right"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card d-none" data-step="1">
    <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
      <div class="card-title mb-3">
        <h3 class="mb-2">Konfirmasi Pendaftaran</h3>
        <small class="text-muted">Harap cek kembali data pendaftaran Anda</small>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          <div class="row mb-3">
            <p class="col-sm-5 col-md-3 form-label mb-0"><b>Nama Lengkap</b></p>
            <div class="col-sm-7 col-md-9">
              <p class="mb-0" id="nama">{{ Auth::user()->nama }}</p>
            </div>
          </div>
          <div class="row mb-3">
            <p class="col-sm-5 col-md-3 form-label mb-0"><b>NIM</b></p>
            <div class="col-sm-7 col-md-9">
              <p class="mb-0" id="nim">{{ Auth::user()->nim }}</p>
            </div>
          </div>
          <div class="row mb-3">
            <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji</b></p>
            <div class="col-sm-7 col-md-9">
              <p class="mb-0" id="penguji">
                @if ($proposal)
                  {{ $proposal->usulan_penguji1 ?? '' }}
                  @if ($proposal->usulan_penguji2)
                    , {{ $proposal->usulan_penguji2 }}
                  @endif
                  @if ($proposal->usulan_penguji3)
                    , {{ $proposal->usulan_penguji3 }}
                  @endif
                @else
                  Belum ada penguji
                @endif
              </p>
            </div>
          </div>
          <div class="row mb-3">
            <p class="col-sm-5 col-md-3 form-label mb-0"><b>Naskah</b></p>
            <div class="col-sm-7 col-md-9">
              <a href="{{ $proposal->file ?? '' }}" target="_blank" rel="noopener noreferrer">
                <p class="mb-0" id="naskah">{{ $proposal->file ?? '' }}</p>
              </a>
            </div>
          </div>
          <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
            <strong class="me-2">Perhatian!</strong> Pastikan data yang Anda masukkan sudah benar, harap cek kembali data pendaftaran Anda sebelum melanjutkan
          </div>
          {{-- submit --}}
          <div class="form-group mb-3 text-end">
            <button class="btn btn-primary waves-effect waves-light" id="pendaftaran_submit">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card d-none" data-step="2">
    <div class="card-header pb-4 d-flex justify-content-center mb-lg-n4">
      @if ($proposal && $proposal->status == 2)
        <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
          <i class="ti ti-clock text-secondary" style="font-size: 10rem;"></i>
          <h3 class="mb-2">Pendaftaran Anda Sedang Diajukan</h3>
          <small class="text-muted">Harap menunggu kaprodi untuk menyetujui pendaftaran Anda</small>
        </div>
      @else
        <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
          <i class="ti ti-circle-check text-success" style="font-size: 10rem;"></i>
          <h3 class="mb-2">Selamat Pendaftaran Anda Diterima</h3>
          <small class="text-muted">Harap menghadiri ujian sesuai dengan jadwal yang ditentukan</small>
        </div>
      @endif
    </div>
    <div class="card-body">
      <div class="row justify-content-center">
        @if ($proposal && $proposal->status == 2)
          <div class="col-12">
            <div class="row mb-3 justify-content-center align-items-center">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Nama Lengkap</b></p>
              <div class="col-sm-7 col-md-5">
                <p class="mb-0" id="nama">{{ Auth::user()->nama }}</p>
              </div>
            </div>
            <div class="row mb-3 justify-content-center align-items-center">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>NIM</b></p>
              <div class="col-sm-7 col-md-5">
                <p class="mb-0" id="nim">{{ Auth::user()->nim }}</p>
              </div>
            </div>
            <div class="row mb-3 justify-content-center align-items-center">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji 1</b></p>
              <div class="col-sm-7 col-md-5">
                <p class="mb-0" id="penguji1">{{ $proposal->usulan_penguji1 ?? '' }}</p>
              </div>
            </div>
            <div class="row mb-3 justify-content-center align-items-center">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji 2</b></p>
              <div class="col-sm-7 col-md-5">
                <p class="mb-0" id="penguji2">{{ $proposal->usulan_penguji2 ?? '' }}</p>
              </div>
            </div>
            @if ($proposal && $proposal->usulan_penguji3)
              <div class="row mb-3 justify-content-center align-items-center">
                <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji 3</b></p>
                <div class="col-sm-7 col-md-5">
                  <p class="mb-0" id="penguji3">{{ $proposal->usulan_penguji3 ?? '' }}</p>
                </div>
              </div>
            @endif
            <div class="row mb-3 justify-content-center align-items-center">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Naskah</b></p>
              <div class="col-sm-7 col-md-5">
                <a href="{{ $proposal->file ?? '' }}" target="_blank" rel="noopener noreferrer">
                  <p class="mb-0" id="naskah">{{ $proposal->file ?? '' }}</p>
                </a>
              </div>
            </div>
          </div>
        @elseif ($proposal && $proposal->status > 2)
          <div class="col-12 col-md-6">
            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Tanggal Ujian</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">{{ \Carbon\Carbon::parse($jadwal_ujian->tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Jam Ujian</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">{{ \Carbon\Carbon::parse($jadwal_ujian->jam)->format('H:i') }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Ruangan Ujian</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">{{ $jadwal_ujian->ruangan }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji 1</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">{{ $jadwal_ujian->penguji1 }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji 2</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">{{ $jadwal_ujian->penguji2 }}</p>
              </div>
            </div>
            @if ($jadwal_ujian && $jadwal_ujian->penguji3)
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji 3</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $jadwal_ujian->penguji3 }}</p>
                </div>
              </div>
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>

  @if ($proposal && $proposal->status == 4)
    <div class="alert alert-warning d-flex align-items-center" role="alert">
      <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
      <strong class="me-2">Perhatian!</strong> Segera lakukan revisi naskah Anda, pastikan naskah yang diupload sudah sesuai dengan catatan penguji
    </div>
  @elseif ($proposal && $proposal->status == 5)
    <div class="alert alert-info d-flex align-items-center" role="alert">
      <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
      <strong class="me-2">Perhatian!</strong> Naskah Anda sedang diajukan untuk revisi, harap menunggu hasil revisi dari penguji
    </div>
  @elseif ($proposal && $proposal->status == 6)
    <div class="alert alert-success d-flex align-items-center" role="alert">
      <i class="ti ti-check-circle me-1 fw-bold"></i>
      <strong class="me-2">Selamat!</strong> Naskah Anda sudah diterima, silahkan melanjutkan ke tahap berikutnya
    </div>
  @endif

  @if ($proposal && $proposal->status > 3)
    <div class="card d-none" data-step="4">
      <div class="card-header pb-4 d-flex justify-content-center mb-lg-n4">
        @if ($proposal && $proposal->status == 4)
          <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
            <i class="ti ti-alert-circle text-warning" style="font-size: 10rem;"></i>
            <h3 class="mb-2 text-warning">Naskah Anda Memerlukan Revisi</h3>
            <small class="text-muted">Harap segera revisi naskah sesuai dengan catatan penguji</small>
          </div>
        @elseif($proposal->status == 5)
          <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
            <i class="ti ti-clock text-secondary" style="font-size: 10rem;"></i>
            <h3 class="mb-2">Revisi Naskah Sedang Diajukan</h3>
            <small class="text-muted">Harap menunggu hasil review dari Kaprodi</small>
          </div>
        @elseif($proposal->status == 6)
          <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
            <i class="ti ti-circle-check text-success" style="font-size: 10rem;"></i>
            <h3 class="mb-2 text-success">Selamat Ujian Anda Selesai</h3>
            <small class="text-muted">Silahkan melanjutkan ke tahap berikutnya</small>
          </div>
        @endif
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8">
            <div class="row mb-4">
              <h5 class="mb-1"><b>Penilaian Penguji</b></h5>
              <div class="">
                @if ($proposal->nilai_penguji1 == 100)
                  <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Penguji 1</span>
                @else
                  <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Penguji 1</span>
                @endif
                @if ($proposal->nilai_penguji2 == 100)
                  <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Penguji 2</span>
                @else
                  <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Penguji 2</span>
                @endif
                @if ($proposal->penguji3_id)
                  @if ($proposal->nilai_penguji3 == 100)
                    <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Penguji 3</span>
                  @else
                    <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Penguji 3</span>
                  @endif
                @endif
                @if ($proposal->nilai_promotor == 100)
                  <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Promotor</span>
                @else
                  <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Promotor</span>
                @endif
                @if ($proposal->nilai_co_promotor1 == 100)
                  <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Co-Promotor 1</span>
                @else
                  <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Co-Promotor 1</span>
                @endif
                @if ($proposal->nilai_co_promotor2 == 100)
                  <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Co-Promotor 2</span>
                @elseif($proposal->nilai_co_promotor2 === null)
                @else
                  <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Co-Promotor 2</span>
                @endif
                @if ($proposal->nilai_kaprodi == 100)
                  <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Kaprodi</span>
                @else
                  <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Kaprodi</span>
                @endif
              </div>
              <small class="mt-2">Keterangan: <span class="badge bg-label-success">Layak</span> <span
                  class="badge bg-label-danger">Tidak Layak</span></small>
            </div>
            <div class="row mb-4">
              <h5 class="mb-1"><b>Komentar Penguji</b></h5>
              <div class="">
                @if ($proposal->komentar1)
                  <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($proposal->komentar1) !!}, 1)'>
                    <i class="ti ti-message me-2"></i> Penguji 1
                  </button>
                @endif
                @if ($proposal->komentar2)
                  <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($proposal->komentar2) !!}, 2)'>
                    <i class="ti ti-message me-2" id="penguji2"></i> Penguji 2
                  </button>
                @endif
                @if ($proposal->komentar3_penguji)
                  <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($proposal->komentar3_penguji) !!}, 3)'>
                    <i class="ti ti-message me-2" id="penguji3"></i> Penguji 3
                  </button>
                @endif
                @if ($proposal->komentar3)
                  <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($proposal->komentar3) !!}, "Promotor")'>
                    <i class="ti ti-message me-2" id="promotor"></i> Promotor
                  </button>
                @endif
                @if ($proposal->komentar4)
                  <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($proposal->komentar4) !!}, "Co-Promotor 1")'>
                    <i class="ti ti-message me-2" id="co_promotor1"></i> Co-Promotor 1
                  </button>
                @endif
                @if ($proposal->komentar5)
                  <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($proposal->komentar5) !!}, "Co-Promotor 2")'>
                    <i class="ti ti-message me-2" id="co_promotor2"></i> Co-Promotor 2
                  </button>
                @endif
                @if ($proposal->komentar6)
                  <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($proposal->komentar6) !!}, "Kaprodi")'>
                    <i class="ti ti-message me-2" id="kaprodi"></i> Kaprodi
                  </button>
                @endif
              </div>
            </div>
            @if ($proposal->status == 4)
              <form action="{{ route('ujian.proposal.revisi') }}" method="post" id="revisi">
                @csrf
                @method('patch')
                <h5 class="mt-3 mb-1"><b>Form Revisi Naskah</b></h5>
                <input type="hidden" name="id_pendaftaran" value="{{ $proposal->id }}">
                <div class="form-group mb-3">
                  <label for="naskah_revisi" class="form-label">Link Google Drive Naskah Baru</label>
                  <input type="url" class="form-control naskah_revisi @error('naskah_revisi') is-invalid @enderror"
                    name="naskah_revisi" value="{{ old('naskah_revisi') }}" placeholder="Masukkan link GDrive naskah"
                    required>
                  @error('naskah_revisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="form-text" id="err2">Pastikan link/url Google Drive naskah dapat diakses</div>
                </div>
                <div class="form-group mb-3 text-end">
                  <button type="submit" class="btn btn-primary btn-next naskah_revisi" id="naskah_revisi">
                    Submit
                  </button>
                </div>
              </form>
            @elseif ($proposal->status == 5)
              <div class="row mb-3">
                <h5 class="mb-1"><b>Link Naskah Revisi</b></h5>
                <div class="">
                  <a href="{{ $proposal->file ?? '' }}" target="_blank" rel="noopener noreferrer">
                    <p class="mb-0" id="naskah">{{ $proposal->file ?? '' }}</p>
                  </a>
                </div>
              </div>
            @elseif ($proposal->status == 6)
              <div class="row mb-4">
                <h5 class="mb-1"><b>Link Naskah Revisi</b></h5>
                <div class="">
                  <a href="{{ $proposal->file ?? '' }}" target="_blank" rel="noopener noreferrer">
                    <p class="mb-0" id="naskah">{{ $proposal->file ?? '' }}</p>
                  </a>
                </div>
              </div>
              <div class="form-group mb-3 text-center">
                <a href="{{ route('ujian.semhas') }}" class="btn btn-primary btn-next">Lanjutkan
                  <i class="ti ti-arrow-right ms-2"></i></a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="modal fade" id="modalComment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="m_title"></h5>
          <button type="button" class="btn-close komentar" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <div id="showkomentars" class="mb-3"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary komentar" data-bs-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    const showkomentars = new Quill('#showkomentars', {
      bounds: '#showkomentars',
      modules: {
        formula: true,
        toolbar: false
      },
      theme: 'snow'
    });
    showkomentars.disable();

    window.showk = function(komentar, num) {
      console.log('clicked');
      $("#m_title").text("Komentar " + num);
      komentar = JSON.parse(komentar);
      showkomentars.setContents(komentar);
    };

    $('#modalComment').on('hidden.bs.modal', function() {
      showkomentars.setContents([]);
    });
  });
</script>
<script>
  $(document).ready(function() {
    var progress = {{ $proposal->status ?? 0 }};
    if (progress == 3) {
      progress = 2;
    } else if (progress > 4) {
      progress = 4;
    }
    init();
    $('[steps]').click(function() {
      var state = $(this).attr('steps');
      changeState(state, this);
    });

    if (progress > 1) {
      $('#ujian_proposan').find('input, select, button').attr('disabled', 'disabled');
      $('.komentar').removeAttr('disabled');
      $('#revisi').find('input, button').removeAttr('disabled');
    }

    function init() {
      $('[data-step]').hide();
      $('[data-step="' + progress + '"]').show();
      $('[data-step="' + progress + '"]').removeClass('d-none');
      $('[data-step]').removeClass('d-none');
      $('[steps="' + progress + '"]').parent().find('span').removeClass();
      $('[steps="' + progress + '"]').parent().find('span').addClass('step-icon step-icon-soft-primary');
      checkStepProgress(progress);
    }

    function checkStepProgress(currentProgress) {
      for (let index = 0; index < currentProgress; index++) {
        $('[steps="' + index + '"]').parent().find('span').removeClass();
        $('[steps="' + index + '"]').parent().find('span').addClass('step-icon step-icon-soft-success');
      }
    }

    window.changeState = function(state, clickedElement) {
      if (state > progress) {
        Swal.fire({
          title: 'Tahap ini belum tersedia',
          text: 'Silahkan lengkapi tahap sebelumnya terlebih dahulu',
          icon: 'warning',
          customClass: {
            confirmButton: 'btn btn-primary'
          },
        });
        return;
      }
      $('[data-step]').hide();
      $('[data-step="' + state + '"]').show();
      $(clickedElement).parent().find('span').addClass('step-icon-active');
      $('[steps]').not(clickedElement).parent().find('span').removeClass('step-icon-active');
    };

    @if (!$proposal)
      $("#dosen_search").select2({
        placeholder: "Pilih Dosen Penguji",
        maximumSelectionLength: 3,
        minimumInputLength: 2,
        language: {
          maximumSelected: function(e) {
            return "Anda hanya dapat memilih maksimal " + e.maximum + " dosen";
          },
          inputTooShort: function(e) {
            return "Masukkan minimal 2 karakter untuk mencari dosen";
          },
          noResults: function() {
            return "Tidak ada dosen yang ditemukan";
          },
          searching: function() {
            return "Mencari...";
          }
        },
        ajax: {
          delay: 500,
          url: $("#dosen_search").data("search-dosen-url"),
          type: "POST",
          headers: {
            "X-CSRF-TOKEN": $("#dosen_search").data("csrf-token")
          },
          data: function(params) {
            return {
              nipNikOrNama: params.term
            };
          },
          processResults: function(response) {
            if (!response || response.error) {
              console.error("Error in response:", response);
              return { results: [] };
            }
            var data = response.map(function(item) {
              return {
                id: item.id,
                nomor_induk: item.no_induk,
                text: item.nama
              };
            });
            return {
              results: data
            };
          },
          cache: true,
          error: function(xhr, status, error) {
            console.error("AJAX error:", status, error, xhr);
          }
        },
        templateResult: formatSearch,
        templateSelection: formatSelection
      });

      function formatSearch(data) {
        if (data.loading) {
          return data.text;
        }
        var $markup = $(
          '<span>' +
          '<h6 class="mb-0">' + data.text + '</h6>' +
          '<span class="text-muted">' + (data.nomor_induk || 'N/A') + '</span>' +
          '</span>'
        );
        return $markup;
      }

      function formatSelection(data) {
        return data.text || data.id;
      }

      $('#dosen_search').on('change', function() {
        var selectedCount = $(this).val() ? $(this).val().length : 0;
        if (selectedCount < 2) {
          $(this).siblings('.invalid-feedback').remove();
          $(this).after('<div class="invalid-feedback d-block">You must select at least 2 examiners</div>');
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
          $(this).siblings('.invalid-feedback').remove();
        }
      });

      $('#pendaftaran').on('submit', function(e) {
        e.preventDefault();

        var selectedDosen = $('#dosen_search').val() ? $('#dosen_search').val().length : 0;
        if (selectedDosen < 2) {
          Swal.fire({
            title: 'Pilih minimal 2 penguji',
            text: 'Anda harus memilih setidaknya 2 dosen sebagai penguji.',
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-primary'
            },
          });
          return;
        }

        let data = $(this).serializeArray();
        console.log(data);
        progress = 1;
        init();
        $('#nama').text(data[1].value);
        $('#nim').text(data[2].value);
        var penguji = [];
        $('#dosen_search option:selected').each(function() {
          penguji.push($(this).text());
        });
        $('#penguji').text(penguji.join(', '));
        $('#naskah').text(data[5].value);
      });

      $('#pendaftaran_submit').on('click', function() {
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Anda tidak dapat mengubah data pendaftaran setelah mengajukan!",
          icon: 'warning',
          customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
          },
          confirmButtonText: 'Ya, Ajukan!',
          cancelButtonText: 'Batal',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            $('#pendaftaran').off('submit');
            $('#pendaftaran').submit();
          }
        });
      });
    @endif
  });
</script>
<script>
  $(document).ready(function() {
    $('.naskah').on('input', function() {
      var url = $(this).val();
      var regex = "";
      if (regex.test(url)) {
        $(this).removeClass('is-invalid');
        $(this).addClass('is-valid');
        $('#err').text('Pastikan link/url Google Drive naskah dapat diakses').removeClass('text-danger');
      } else {
        $(this).removeClass('is-valid');
        $(this).addClass('is-invalid');
        $('#err').text('Link/url Google Drive naskah tidak valid').addClass('text-danger');
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('.naskah_revisi').on('input', function() {
      var url = $(this).val();
      var regex = "";
      if (regex.test(url)) {
        $(this).removeClass('is-invalid');
        $(this).addClass('is-valid');
        $('#err2').text('Pastikan link/url Google Drive naskah dapat diakses').removeClass('text-danger');
      } else {
        $(this).removeClass('is-valid');
        $(this).addClass('is-invalid');
        $('#err2').text('Link/url Google Drive naskah tidak valid').addClass('text-danger');
      }
    });
  });
</script>
@endsection

@push('scripts')
@endpush