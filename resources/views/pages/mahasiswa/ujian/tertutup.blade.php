@extends('layouts.mahasiswa.app')
@section('title', 'Seminar Hasil')

@section('content')
  <div class="col-lg-12 mb-4 h-100" id="ujian_proposan">
    <div class="card mb-3">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h2 class="mb-2">Ujian Disertasi Tertutup</h2>
          <small class="text-muted">
            Proses Ujian Disertasi Tertutup. Tahap ini terdiri dari 4 tahapan utama yaitu
            pendaftaran, konfirmasi, status, dan finalisasi ujian. Harap mengikuti tahapan sesuai dengan petunjuk yang diberikan
          </small>
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
                  <p class="step-text">Isi data dan ajukan penguji</p>
                </div>
              </div>
            </li>
            <li class="step-item">
              <div class="step-content-wrapper">
                <span steps="1" class="step-icon step-icon-soft-secondary">2</span>
                <div class="step-content">
                  <h4 class="step-title">Konfirmasi</h4>
                  <p class="step-text">Konfirmasi pendaftaran</p>
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
                  <p class="step-text">Finalisasi & revisi naskah</p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    {{-- STEP 0: FORM PENDAFTARAN --}}
    <div class="card d-none" data-step="0">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h3 class="mb-2">Form Pendaftaran</h3>
          <small class="text-muted">Harap isi form pendaftaran dengan benar, kolom bertanda (*) wajib diisi</small>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <form action="{{ route('ujian.tertutup.store') }}" method="post" id="pendaftaran">
              @csrf

              {{-- Nama & NIM --}}
              <div class="form-group row mb-3">
                <div class="col-12 col-md-6">
                  <label for="nama" class="col-form-label required">Nama</label>
                  <input type="text" class="form-control" name="nama" value="{{ Auth::user()->nama }}" readonly>
                  <div class="form-text">Nama & NIM diambil otomatis dari data mahasiswa</div>
                </div>
                <div class="col-12 col-md-6">
                  <label for="nim" class="col-form-label required">NIM</label>
                  <input type="text" class="form-control" name="nim" value="{{ Auth::user()->nim }}" readonly>
                </div>
              </div>

              {{-- Usulan Penguji (2–3) --}}
              <div class="form-group mb-3">
                <label for="usulan_penguji" class="col-form-label required">Usulan Penguji</label>
                <select
                  class="form-select @error('usulan_penguji') is-invalid @enderror"
                  id="dosen_search"
                  name="usulan_penguji[]"
                  multiple="multiple"
                  data-search-dosen-url="{{ route('search.dosen') }}"
                  data-csrf-token="{{ csrf_token() }}"
                  required
                >
                  @if ($tertutup)
                    <option value="{{ $tertutup->penguji1_id ?? '' }}" selected>{{ $tertutup->usulan_penguji1 ?? '' }}</option>
                    <option value="{{ $tertutup->penguji2_id ?? '' }}" selected>{{ $tertutup->usulan_penguji2 ?? '' }}</option>
                    @if ($tertutup->penguji3_id)
                      <option value="{{ $tertutup->penguji3_id }}" selected>{{ $tertutup->usulan_penguji3 ?? '' }}</option>
                    @endif
                  @endif
                </select>
                <div class="form-text">Silakan ajukan minimal 2 dosen (maksimal 3 dosen).</div>
                @error('usulan_penguji')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Usulan Penguji Eksternal 1 (opsional) --}}
              <div class="form-group row mb-3">
                <div class="col-12 col-md-4">
                  <label for="nama_px1" class="col-form-label">Usulan Penguji Eksternal 1</label>
                  <input type="text" class="form-control @error('nama_px1') is-invalid @enderror" name="nama_px1" id="nama_px1"
                    value="{{ old('nama_px1', $tertutup->penguji_eks1->nama ?? '') }}" placeholder="Nama">
                </div>
                <div class="col-12 col-md-4 d-flex align-items-end">
                  <input type="text" class="form-control @error('id_px1') is-invalid @enderror" name="id_px1" id="id_px1"
                    value="{{ old('id_px1', $tertutup->penguji_eks1->id ?? '') }}" placeholder="NIK/NIP/NIDN">
                </div>
                <div class="col-12 col-md-4 d-flex align-items-end">
                  <input type="email" class="form-control @error('email_px1') is-invalid @enderror" name="email_px1" id="email_px1"
                    value="{{ old('email_px1', $tertutup->penguji_eks1->email ?? '') }}" placeholder="email@example.com">
                </div>
                <div class="form-text">Field ini opsional.</div>
                @error('nama_px1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @error('id_px1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @error('email_px1') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- LINK NASKAH (URL) --}}
              <div class="form-group mb-3">
                <label for="naskah" class="form-label required">Link Naskah (URL)</label>
                <input
                  type="url"
                  name="naskah"
                  class="form-control naskah @error('naskah') is-invalid @enderror"
                  id="naskah_f"
                  value="{{ old('naskah', $tertutup->file ?? '') }}"
                  placeholder="https://drive.google.com/..."
                  required
                >
                @error('naskah')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text" id="err">Pastikan link dapat diakses (public)</div>
              </div>

              {{-- Submit --}}
              <div class="form-group mb-3 text-end">
                <button type="submit" class="btn btn-primary btn-next" id="btn_next_step0">
                  <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Selanjutnya</span>
                  <i class="ti ti-arrow-right"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- STEP 1: KONFIRMASI --}}
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
                  @if ($tertutup)
                    {{ $tertutup->usulan_penguji1 ?? '' }}
                    @if ($tertutup->usulan_penguji2), {{ $tertutup->usulan_penguji2 }} @endif
                    @if ($tertutup->usulan_penguji3), {{ $tertutup->usulan_penguji3 }} @endif
                  @else
                    Belum ada penguji
                  @endif
                </p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji Eksternal 1</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0" id="penguji_e1">{{ $tertutup->penguji_eks1->nama ?? '-' }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Naskah</b></p>
              <div class="col-sm-7 col-md-9">
                @if ($tertutup && $tertutup->file)
                  <a href="{{ $tertutup->file }}" target="_blank" rel="noopener noreferrer">{{ $tertutup->file }}</a>
                @else
                  <a id="naskah" href="#" target="_blank" rel="noopener noreferrer"></a>
                @endif
              </div>
            </div>

            <div class="alert alert-info d-flex align-items-center" role="alert">
              <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
              <strong class="me-2">Perhatian!</strong> Pastikan data yang Anda masukkan sudah benar sebelum melanjutkan
            </div>

            <div class="form-group mb-3 text-end">
              <button class="btn btn-primary waves-effect waves-light" id="pendaftaran_submit">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- STEP 2: STATUS --}}
    <div class="card d-none" data-step="2">
      <div class="card-header pb-4 d-flex justify-content-center mb-lg-n4">
        @if ($tertutup && $tertutup->status == 2)
          <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
            <i class="ti ti-clock text-secondary" style="font-size: 10rem;"></i>
            <h3 class="mb-2">Pendaftaran Anda Sedang Diajukan</h3>
            <small class="text-muted">Menunggu persetujuan Kaprodi</small>
          </div>
        @else
          <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
            <i class="ti ti-circle-check text-success" style="font-size: 10rem;"></i>
            <h3 class="mb-2">Selamat, Pendaftaran Diterima</h3>
            <small class="text-muted">Silakan hadiri ujian sesuai jadwal</small>
          </div>
        @endif
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          @if ($tertutup && $tertutup->status == 2)
            <div class="col-12">
              <div class="row mb-3 justify-content-center align-items-center">
                <p class="col-sm-5 col-md-3 form-label mb-0"><b>Nama Lengkap</b></p>
                <div class="col-sm-7 col-md-5"><p class="mb-0">{{ Auth::user()->nama }}</p></div>
              </div>
              <div class="row mb-3 justify-content-center align-items-center">
                <p class="col-sm-5 col-md-3 form-label mb-0"><b>NIM</b></p>
                <div class="col-sm-7 col-md-5"><p class="mb-0">{{ Auth::user()->nim }}</p></div>
              </div>
              <div class="row mb-3 justify-content-center align-items-center">
                <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji 1</b></p>
                <div class="col-sm-7 col-md-5"><p class="mb-0">{{ $tertutup->usulan_penguji1 ?? '' }}</p></div>
              </div>
              <div class="row mb-3 justify-content-center align-items-center">
                <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji 2</b></p>
                <div class="col-sm-7 col-md-5"><p class="mb-0">{{ $tertutup->usulan_penguji2 ?? '' }}</p></div>
              </div>
              @if ($tertutup->usulan_penguji3)
                <div class="row mb-3 justify-content-center align-items-center">
                  <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji 3</b></p>
                  <div class="col-sm-7 col-md-5"><p class="mb-0">{{ $tertutup->usulan_penguji3 ?? '' }}</p></div>
                </div>
              @endif
              @if ($tertutup->penguji_eks1)
                <div class="row mb-3 justify-content-center align-items-center">
                  <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji Eksternal 1</b></p>
                  <div class="col-sm-7 col-md-5"><p class="mb-0">{{ $tertutup->penguji_eks1->nama ?? '' }}</p></div>
                </div>
              @endif
              <div class="row mb-3 justify-content-center align-items-center">
                <p class="col-sm-5 col-md-3 form-label mb-0"><b>Naskah</b></p>
                <div class="col-sm-7 col-md-5">
                  <a href="{{ $tertutup->file ?? '#' }}" target="_blank" rel="noopener noreferrer">
                    <p class="mb-0">{{ $tertutup->file ?? '' }}</p>
                  </a>
                </div>
              </div>
            </div>
          @elseif ($tertutup && $tertutup->status > 2)
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
                <div class="col-sm-7 col-md-8"><p class="mb-0">{{ $jadwal_ujian->penguji1 }}</p></div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji 2</b></p>
                <div class="col-sm-7 col-md-8"><p class="mb-0">{{ $jadwal_ujian->penguji2 }}</p></div>
              </div>
              @if ($jadwal_ujian->penguji3)
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji 3</b></p>
                  <div class="col-sm-7 col-md-8"><p class="mb-0">{{ $jadwal_ujian->penguji3 }}</p></div>
                </div>
              @endif
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Eksternal</b></p>
                <div class="col-sm-7 col-md-8"><p class="mb-0">{{ $jadwal_ujian->penguji_eks }}</p></div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- ALERT FINALISASI --}}
    @if ($tertutup && $tertutup->status == 4)
      <div class="alert alert-warning d-flex align-items-center" role="alert">
        <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
        <strong class="me-2">Perhatian!</strong> Segera lakukan revisi naskah sesuai catatan penguji
      </div>
    @elseif ($tertutup && $tertutup->status == 5)
      <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
        <strong class="me-2">Perhatian!</strong> Naskah revisi diajukan—menunggu hasil review
      </div>
    @elseif ($tertutup && $tertutup->status == 6)
      <div class="alert alert-success d-flex align-items-center" role="alert">
        <i class="ti ti-check-circle me-1 fw-bold"></i>
        <strong class="me-2">Selamat!</strong> Naskah Anda diterima, lanjut ke tahap berikutnya
      </div>
    @endif

    {{-- STEP 4: FINALISASI / REVISI --}}
    @if ($tertutup && $tertutup->status > 3)
      <div class="card d-none" data-step="4">
        <div class="card-header pb-4 d-flex justify-content-center mb-lg-n4">
          @if ($tertutup->status == 4)
            <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
              <i class="ti ti-alert-circle text-warning" style="font-size: 10rem;"></i>
              <h3 class="mb-2 text-warning">Naskah Memerlukan Revisi</h3>
              <small class="text-muted">Harap segera revisi naskah sesuai catatan penguji</small>
            </div>
          @elseif ($tertutup->status == 5)
            <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
              <i class="ti ti-clock text-secondary" style="font-size: 10rem;"></i>
              <h3 class="mb-2">Revisi Naskah Diajukan</h3>
              <small class="text-muted">Menunggu hasil review Kaprodi</small>
            </div>
          @elseif ($tertutup->status == 6)
            <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
              <i class="ti ti-circle-check text-success" style="font-size: 10rem;"></i>
              <h3 class="mb-2 text-success">Selamat Ujian Selesai</h3>
              <small class="text-muted">Silakan melanjutkan</small>
            </div>
          @endif
        </div>

        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-12 col-md-8">
              {{-- Penilaian (contoh badge) --}}
              <div class="row mb-4">
                <h5 class="mb-1"><b>Penilaian Penguji</b></h5>
                <div>
                  @if ($tertutup->nilai_penguji1 !== null)
                    <span class="badge {{ $tertutup->nilai_penguji1 > 50 ? 'bg-label-success' : 'bg-label-danger' }} m-1">
                      Penguji 1: {{ $tertutup->nilai_penguji1 }}
                    </span>
                  @endif
                  @if ($tertutup->nilai_penguji2 !== null)
                    <span class="badge {{ $tertutup->nilai_penguji2 > 50 ? 'bg-label-success' : 'bg-label-danger' }} m-1">
                      Penguji 2: {{ $tertutup->nilai_penguji2 }}
                    </span>
                  @endif
                  @if ($tertutup->nilai_penguji3 !== null)
                    <span class="badge {{ $tertutup->nilai_penguji3 > 50 ? 'bg-label-success' : 'bg-label-danger' }} m-1">
                      Penguji 3: {{ $tertutup->nilai_penguji3 }}
                    </span>
                  @endif
                  @if ($tertutup->nilai_promotor !== null)
                    <span class="badge {{ $tertutup->nilai_promotor > 50 ? 'bg-label-success' : 'bg-label-danger' }} m-1">
                      Promotor: {{ $tertutup->nilai_promotor }}
                    </span>
                  @endif
                  @if ($tertutup->nilai_co_promotor1 !== null)
                    <span class="badge {{ $tertutup->nilai_co_promotor1 > 50 ? 'bg-label-success' : 'bg-label-danger' }} m-1">
                      Co-Promotor 1: {{ $tertutup->nilai_co_promotor1 }}
                    </span>
                  @endif
                  @if ($tertutup->nilai_co_promotor2 !== null)
                    <span class="badge {{ $tertutup->nilai_co_promotor2 > 50 ? 'bg-label-success' : 'bg-label-danger' }} m-1">
                      Co-Promotor 2: {{ $tertutup->nilai_co_promotor2 }}
                    </span>
                  @endif
                  @if ($tertutup->nilai_penguji_eks !== null)
                    <span class="badge {{ $tertutup->nilai_penguji_eks > 50 ? 'bg-label-success' : 'bg-label-danger' }} m-1">
                      Penguji Eksternal: {{ $tertutup->nilai_penguji_eks }}
                    </span>
                  @endif
                  @if ($tertutup->nilai_kaprodi !== null)
                    <span class="badge {{ $tertutup->nilai_kaprodi > 50 ? 'bg-label-success' : 'bg-label-danger' }} m-1">
                      Kaprodi: {{ $tertutup->nilai_kaprodi }}
                    </span>
                  @endif
                </div>
              </div>

              {{-- Komentar Penguji (Quill read-only) --}}
              <div class="row mb-4">
                <h5 class="mb-1"><b>Komentar Penguji</b></h5>
                <div>
                  @if ($tertutup->komentar1)
                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($tertutup->komentar1) !!}, 1)'>
                      <i class="ti ti-message me-2"></i> Penguji 1
                    </button>
                  @endif
                  @if ($tertutup->komentar2)
                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($tertutup->komentar2) !!}, 2)'>
                      <i class="ti ti-message me-2"></i> Penguji 2
                    </button>
                  @endif
                  @if ($tertutup->komentar3)
                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($tertutup->komentar3) !!}, 3)'>
                      <i class="ti ti-message me-2"></i> Penguji 3
                    </button>
                  @endif
                  @if ($tertutup->komentar4)
                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($tertutup->komentar4) !!}, "Promotor")'>
                      <i class="ti ti-message me-2"></i> Promotor
                    </button>
                  @endif
                  @if ($tertutup->komentar5)
                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($tertutup->komentar5) !!}, "Co-Promotor 1")'>
                      <i class="ti ti-message me-2"></i> Co-Promotor 1
                    </button>
                  @endif
                  @if ($tertutup->komentar7)
                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($tertutup->komentar7) !!}, "Co-Promotor 2")'>
                      <i class="ti ti-message me-2"></i> Co-Promotor 2
                    </button>
                  @endif
                  @if ($tertutup->komentar_eks)
                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($tertutup->komentar_eks) !!}, "Eksternal")'>
                      <i class="ti ti-message me-2"></i> Penguji Eksternal
                    </button>
                  @endif
                  @if ($tertutup->komentar6)
                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($tertutup->komentar6) !!}, "Kaprodi")'>
                      <i class="ti ti-message me-2"></i> Kaprodi
                    </button>
                  @endif
                </div>
              </div>

              {{-- Revisi (Link URL) --}}
              @if ($tertutup->status == 4)
                <form action="{{ route('ujian.tertutup.revisi') }}" method="post" id="revisi">
                  @csrf
                  @method('patch')
                  <h5 class="mt-3 mb-1"><b>Form Revisi Naskah</b></h5>
                  <input type="hidden" name="id_pendaftaran" value="{{ $tertutup->id }}">
                  <div class="form-group mb-3">
                    <label for="naskah_revisi" class="form-label required">Link Naskah Revisi (URL)</label>
                    <input
                      type="url"
                      name="naskah_revisi"
                      class="form-control naskah_revisi @error('naskah_revisi') is-invalid @enderror"
                      id="naskah_revisi"
                      value="{{ old('naskah_revisi') }}"
                      placeholder="https://drive.google.com/..."
                      required
                    >
                    @error('naskah_revisi')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text" id="err2">Pastikan link dapat diakses (public)</div>
                  </div>
                  <div class="form-group mb-3 text-end">
                    <button type="submit" class="btn btn-primary btn-next">Submit</button>
                  </div>
                </form>
              @elseif ($tertutup->status == 5)
                <div class="row mb-3">
                  <h5 class="mb-1"><b>Link Naskah Revisi</b></h5>
                  <div>
                    @if ($tertutup->file)
                      <a href="{{ $tertutup->file }}" target="_blank" rel="noopener noreferrer">{{ $tertutup->file }}</a>
                    @endif
                  </div>
                </div>
              @elseif ($tertutup->status == 6)
                <div class="row mb-4">
                  <h5 class="mb-1"><b>Link Naskah</b></h5>
                  <div>
                    @if ($tertutup->file)
                      <a href="{{ $tertutup->file }}" target="_blank" rel="noopener noreferrer">{{ $tertutup->file }}</a>
                    @endif
                  </div>
                </div>
              @endif

            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

  {{-- MODAL KOMENTAR (Quill read-only) --}}
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
    $(document).ready(function () {
      // Inisialisasi Quill read-only
      const showkomentars = new Quill('#showkomentars', {
        bounds: '#showkomentars',
        modules: { formula: true, toolbar: false },
        theme: 'snow'
      });
      showkomentars.disable();

      // Fungsi tampil komentar (otomatis parse bila string JSON)
      window.showk = function (komentar, num) {
        $("#m_title").text("Komentar " + num);

        // Jika komentar berupa string JSON (hasil json_encode dari string), parse dulu
        try {
          if (typeof komentar === 'string') {
            komentar = JSON.parse(komentar);
          }
        } catch (e) {
          // Jika parsing gagal, kosongkan agar tidak error
          komentar = [];
        }

        // Pastikan minimal array/object Delta
        if (!komentar) komentar = [];
        showkomentars.setContents(komentar);
      };

      // Bersihkan isi saat modal ditutup (opsional, biar rapi)
      $('#modalComment').on('hidden.bs.modal', function () {
        showkomentars.setContents([]);
      });
    });
  </script>

  <script>
    $(document).ready(function () {
      var progress = {{ $tertutup->status ?? 0 }};
      if (progress == 3) { progress = 2; }
      else if (progress > 4) { progress = 4; }

      init();

      $('[steps]').click(function () {
        var state = $(this).attr('steps');
        changeState(state, this);
      });

      // Nonaktifkan form ketika progress > 1 (kecuali komentar & form revisi)
      if (progress > 1) {
        $('[data-step="0"]').find('input, select, button, textarea').prop('disabled', true);
        $('.komentar').prop('disabled', false);
        $('#revisi').find('input, button, textarea').prop('disabled', false);
      }

      function init() {
        $('[data-step]').hide();
        $('[data-step="' + progress + '"]').show().removeClass('d-none');
        $('[data-step]').removeClass('d-none');
        $('[steps="' + progress + '"]').parent().find('span')
          .removeClass().addClass('step-icon step-icon-soft-primary');
        checkStepProgress(progress);
      }

      function checkStepProgress(currentProgress) {
        for (let index = 0; index < currentProgress; index++) {
          $('[steps="' + index + '"]').parent().find('span')
            .removeClass().addClass('step-icon step-icon-soft-success');
        }
      }

      window.changeState = function (state, clickedElement) {
        if (state > progress) {
          Swal.fire({
            title: 'Tahap ini belum tersedia',
            text: 'Lengkapi tahap sebelumnya terlebih dahulu',
            icon: 'warning',
            customClass: { confirmButton: 'btn btn-primary' },
          });
          return;
        }
        $('[data-step]').hide();
        $('[data-step="' + state + '"]').show();
        $(clickedElement).parent().find('span').addClass('step-icon-active');
        $('[steps]').not(clickedElement).parent().find('span').removeClass('step-icon-active');
      };

      @if (!$tertutup)
        // Preview ke Step 1 tanpa submit server
        $('#pendaftaran').on('submit', function (e) {
          e.preventDefault();

          progress = 1;
          init();

          // Ambil by name (tidak mengandalkan index serializeArray)
          const formData = Object.fromEntries(new FormData(this).entries());

          $('#nama').text(formData.nama || '');
          $('#nim').text(formData.nim || '');

          var penguji = [];
          $('#dosen_search option:selected').each(function () {
            penguji.push($(this).text());
          });
          $('#penguji').text(penguji.join(', '));

          var penguji_eks1 = ($('#nama_px1').val() || '-') + ' - ' + ($('#id_px1').val() || '-') + ' - ' + ($('#email_px1').val() || '-');
          $('#penguji_e1').text(penguji_eks1);

          var naskah = $('#naskah_f').val();
          if (naskah) {
            $('.card[data-step="1"] #naskah').attr('href', naskah).text(naskah);
          }
        });

        // Konfirmasi submit
        $('#pendaftaran_submit').on('click', function () {
          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak dapat mengubah data pendaftaran setelah mengajukan!',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
              confirmButton: 'btn btn-primary',
              cancelButton: 'btn btn-outline-danger ml-1'
            },
            confirmButtonText: 'Ya, Ajukan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              $('#pendaftaran').off('submit').trigger('submit');
            }
          });
        });
      @endif
    });
  </script>
@endsection

@push('scripts')
  {{-- Tidak ada Dropify atau regex --}}
@endpush
