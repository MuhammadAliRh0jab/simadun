@extends('layouts.mahasiswa.app')
@section('title', 'Ujian Publikasi')

@section('content')
    <div class="col-lg-12 mb-4 h-100" id="ujian_proposan">
        {{-- Card Stepper (Tidak ada perubahan) --}}
        <div class="card mb-3">
            <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-3">
                    <h2 class="mb-2">Ujian Publikasi</h2>
                    <small class="text-muted">Proses pengajuan ujian publikasi. Tahap ini terdiri dari 4 tahapan utama yaitu
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

        {{-- Card Form Pendaftaran (data-step="0") --}}
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
                        <form action="{{ route('ujian.publikasi.store') }}" method="post" id="pendaftaran">
                            @csrf
                            {{-- Nama & NIM --}}
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
                            {{-- Usulan Penguji --}}
                            <div class="form-group mb-3">
                                <label for="usulan_penguji" class="form-label">Usulan Penguji</label>
                                <select class="form-select @error('usulan_penguji') is-invalid @enderror" multiple="multiple"
                                    id="dosen_search" name="usulan_penguji[]" data-search-dosen-url="{{ route('search.dosen') }}"
                                    data-csrf-token="{{ csrf_token() }}" required>
                                    @if ($publikasi)
                                        <option value="{{ $publikasi->penguji1_id ?? '' }}" selected>
                                            {{ $publikasi->usulan_penguji1 ?? '' }}
                                        </option>
                                        <option value="{{ $publikasi->penguji2_id ?? '' }}" selected>
                                            {{ $publikasi->usulan_penguji2 ?? '' }}
                                        </option>
                                        @if ($publikasi->penguji3_id)
                                            <option value="{{ $publikasi->penguji3_id }}" selected>
                                            {{ $publikasi->usulan_penguji3 ?? '' }}
                                            </option>
                                        @endif
                                    @endif
                                </select>
                                <div class="form-text">Silahkan mengajukan minimal 2 dosen sebagai penguji (maksimal 3 dosen).</div>
                                @error('usulan_penguji')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ============================ KODE BARU DITAMBAHKAN ============================ --}}
                            <div class="form-group mb-3">
                                <label for="naskah" class="form-label">Link Google Drive Naskah Kelayakan Disertasi</label>
                                <input type="url" class="form-control naskah @error('naskah') is-invalid @enderror" name="naskah"
                                    value="{{ old('naskah', $publikasi->file ?? '') }}" placeholder="Masukkan link Google Drive naskah" required>
                                @error('naskah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text err" id="err">Pastikan link/url Google Drive naskah dapat diakses.</div>
                            </div>
                            {{-- ========================== AKHIR KODE BARU DITAMBAHKAN ========================== --}}

                            {{-- Daftar Publikasi Jurnal & Konferensi --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Publikasi Jurnal</label>
                                @forelse ($publikasi_jurnal as $jurnal)
                                    <div class="card border-1 p-3 shadow-none mb-1">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title mb-0">{{ $jurnal->judul }}</h5>
                                                <p class="card-text mb-0">{{ $jurnal->jurnal }}</p>
                                            </div>
                                            <div class="col-6 d-flex flex-column justify-content-start align-items-end">
                                                <p class="card-text text-end mb-0">({{ $jurnal->tanggal_terbit }}), {{ $jurnal->volume }}({{ $jurnal->nomor }})</p>
                                                <div class="text-end mt-2">
                                                    <a href="{{ $jurnal->link }}" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">Lihat <i class="ms-2 ti ti-link"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="form-text">Belum ada publikasi jurnal.</p>
                                @endforelse
                                <label class="form-label mt-3">Publikasi Conference</label>
                                @forelse ($publikasi_conference as $conference)
                                     <div class="card border-1 p-3 shadow-none mb-1">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title mb-0">{{ $conference->judul }}</h5>
                                                <p class="card-text mb-0 small">{{ $conference->namaConference }}</p>
                                                <p class="card-text mb-0 small">{{ $conference->penyelenggara }}, ({{ $conference->tanggal_conference }})</p>
                                            </div>
                                            <div class="col-6 d-flex flex-column justify-content-start align-items-end">
                                                <p class="card-text text-end mb-0">({{ $conference->tanggalPublikasi }}), {{ $conference->lokasi_Conference }}</p>
                                                <div class="text-end mt-2">
                                                    <a href="{{ $conference->link }}" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">Lihat <i class="ms-2 ti ti-link"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="form-text">Belum ada publikasi conference.</p>
                                @endforelse
                            </div>

                            <div class="alert alert-warning d-flex align-items-start" role="alert">
                                <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                                <strong class="me-2">Perhatian!</strong> Selain data publikasi yang diambil otomatis, Anda wajib melampirkan Naskah Kelayakan Disertasi. Pastikan semua data yang Anda masukkan sudah benar sebelum melanjutkan.
                            </div>
                            <div class="form-group mb-3 text-end">
                                <button type="submit" class="btn btn-primary btn-next" id="pendaftaran">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Selanjutnya</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Konfirmasi Pendaftaran (data-step="1") --}}
        <div class="card d-none" data-step="1">
            <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-3">
                    <h3 class="mb-2">Konfirmasi Pendaftaran</h3>
                    <small class="text-muted">Harap cek kembali data pendaftaran anda</small>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row mb-3">
                            <p class="col-sm-5 col-md-3 form-label mb-0"><b>Nama Lengkap</b></p>
                            <div class="col-sm-7 col-md-9">
                                <p class="mb-0">{{ Auth::user()->nama }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <p class="col-sm-5 col-md-3 form-label mb-0"><b>NIM</b></p>
                            <div class="col-sm-7 col-md-9">
                                <p class="mb-0">{{ Auth::user()->nim }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji</b></p>
                            <div class="col-sm-7 col-md-9">
                                <p class="mb-0" id="penguji"></p>
                            </div>
                        </div>

                        {{-- ============================ KODE BARU DITAMBAHKAN ============================ --}}
                        <div class="row mb-3">
                            <p class="col-sm-5 col-md-3 form-label mb-0"><b>Naskah Kelayakan Disertasi</b></p>
                            <div class="col-sm-7 col-md-9">
                                <a href="#" target="_blank" rel="noopener noreferrer" id="naskah_link">
                                    <p class="mb-0" id="naskah"></p>
                                </a>
                            </div>
                        </div>
                        {{-- ========================== AKHIR KODE BARU DITAMBAHKAN ========================== --}}

                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                            <strong class="me-2">Perhatian!</strong> Pastikan data yang anda masukkan sudah benar. Anda tidak dapat mengubah data setelah pendaftaran diajukan.
                        </div>
                        <div class="form-group mb-3 text-end">
                            <button class="btn btn-primary waves-effect waves-light" id="pendaftaran_submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Status dan Finalisasi (data-step="2" dan "4") --}}
        {{-- Tidak ada perubahan pada card data-step="2" dan data-step="4" --}}
        <div class="card d-none" data-step="2">
            <div class="card-header pb-4 d-flex justify-content-center mb-lg-n4">
                @if ($publikasi && $publikasi->status == 2)
                    <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
                        <i class="ti ti-clock text-secondary" style="font-size: 10rem;"></i>
                        <h3 class="mb-2">Pendaftaran anda sedang diajukan</h3>
                        <small class="text-muted">Harap menunggu kaprodi untuk menyetujui pendaftaran anda</small>
                    </div>
                @else
                    <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
                        <i class="ti ti-circle-check text-success" style="font-size: 10rem;"></i>
                        <h3 class="mb-2">Selamat Pendaftaran Anda diterima</h3>
                        <small class="text-muted">Harap untuk menghadiri ujian sesuai dengan jadwal yang ditentukan</small>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    @if ($publikasi && $publikasi->status == 2)
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
                                    <p class="mb-0" id="penguji">{{ $publikasi->usulan_penguji1 ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center align-items-center">
                                <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji 2</b></p>
                                <div class="col-sm-7 col-md-5">
                                    <p class="mb-0" id="penguji">{{ $publikasi->usulan_penguji2 ?? '' }}</p>
                                </div>
                            </div>
                            @if ($publikasi->usulan_penguji3)
                                <div class="row mb-3 justify-content-center align-items-center">
                                    <p class="col-sm-5 col-md-3 form-label mb-0"><b>Usulan Penguji 3</b></p>
                                    <div class="col-sm-7 col-md-5">
                                        <p class="mb-0" id="penguji">{{ $publikasi->usulan_penguji3 }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @elseif ($publikasi && $publikasi->status > 2)
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
                            @if ($jadwal_ujian->penguji3)
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

        @if ($publikasi && $publikasi->status == 4)
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                <strong class="me-2">Perhatian!</strong> Segera lakukan revisi naskah anda, pastikan naskah yang diupload sudah sesuai dengan catatan penguji
            </div>
        @elseif ($publikasi && $publikasi->status == 5)
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                <strong class="me-2">Perhatian!</strong> Naskah anda sedang diajukan untuk revisi, harap menunggu hasil revisi dari penguji
            </div>
        @elseif ($publikasi && $publikasi->status == 6)
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="ti ti-check-circle me-1 fw-bold"></i>
                <strong class="me-2">Selamat!</strong> Naskah anda sudah diterima, silahkan melanjutkan ke tahap berikutnya
            </div>
        @endif

        @if ($publikasi && $publikasi->status > 3)
            <div class="card d-none" data-step="4">
                <div class="card-header pb-4 d-flex justify-content-center mb-lg-n4">
                    @if ($publikasi && $publikasi->status == 4)
                        <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
                            <i class="ti ti-alert-circle text-warning" style="font-size: 10rem;"></i>
                            <h3 class="mb-2 text-warning">Naskah anda memerlukan revisi</h3>
                            <small class="text-muted">Harap segera revisi naskah sesuai dengan catatan penguji</small>
                        </div>
                    @elseif ($publikasi->status == 5)
                        <div class="card-title mb-3 d-flex justify-content-center align-items-center flex-column mb-5">
                            <i class="ti ti-clock text-secondary" style="font-size: 10rem;"></i>
                            <h3 class="mb-2">Revisi naskah sedang diajukan</h3>
                            <small class="text-muted">Harap menunggu hasil review dari Kaprodi</small>
                        </div>
                    @elseif ($publikasi->status == 6)
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
                                <div>
                                    @if ($publikasi->nilai_penguji1 == 100)
                                        <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Penguji 1</span>
                                    @else
                                        <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Penguji 1</span>
                                    @endif
                                    @if ($publikasi->nilai_penguji2 == 100)
                                        <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Penguji 2</span>
                                    @else
                                        <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Penguji 2</span>
                                    @endif
                                    @if ($publikasi->nilai_penguji3 === null)
                                        @elseif ($publikasi->nilai_penguji3 == 100)
                                        <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Penguji 3</span>
                                    @else
                                        <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Penguji 3</span>
                                    @endif
                                    @if ($publikasi->nilai_promotor == 100)
                                        <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Promotor</span>
                                    @else
                                        <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Promotor</span>
                                    @endif
                                    @if ($publikasi->nilai_co_promotor1 == 100)
                                        <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Co-Promotor 1</span>
                                    @else
                                        <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Co-Promotor 1</span>
                                    @endif
                                    @if ($publikasi->nilai_co_promotor2 == 100)
                                        <span class="badge bg-label-success m-1"><i class="ti ti-circle-check"></i> Co-Promotor 2</span>
                                    @elseif ($publikasi->nilai_co_promotor2 === null)
                                    @elseif ($publikasi->nilai_co_promotor2 == 0)
                                        <span class="badge bg-label-danger m-1"><i class="ti ti-circle-x"></i> Co-Promotor 2</span>
                                    @endif
                                    @if ($publikasi->nilai_kaprodi == 100)
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
                                    @if ($publikasi->komentar1)
                                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                                        onclick='showk({!! json_encode($publikasi->komentar1) !!}, 1)'>
                                        <i class="ti ti-message me-2"></i> Penguji 1
                                    </button>
                                    @endif
                                    @if ($publikasi->komentar2)
                                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                                        onclick='showk({!! json_encode($publikasi->komentar2) !!}, 2)'>
                                        <i class="ti ti-message me-2" id="penguji2"></i> Penguji 2
                                    </button>
                                    @endif
                                    @if ($publikasi->komentar3_penguji)
                                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                                        onclick='showk({!! json_encode($publikasi->komentar3_penguji) !!}, 3)'>
                                        <i class="ti ti-message me-2" id="penguji3"></i> Penguji 3
                                    </button>
                                    @endif
                                    @if ($publikasi->komentar3)
                                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                                        onclick='showk({!! json_encode($publikasi->komentar3) !!}, "Promotor")'>
                                        <i class="ti ti-message me-2" id="promotor"></i> Promotor
                                    </button>
                                    @endif
                                    @if ($publikasi->komentar4)
                                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                                        onclick='showk({!! json_encode($publikasi->komentar4) !!}, "Co-Promotor 1")'>
                                        <i class="ti ti-message me-2" id="co_promotor1"></i> Co-Promotor 1
                                    </button>
                                    @endif
                                    @if ($publikasi->komentar5)
                                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                                        onclick='showk({!! json_encode($publikasi->komentar5) !!}, "Co-Promotor 2")'>
                                        <i class="ti ti-message me-2" id="co_promotor2"></i> Co-Promotor 2
                                    </button>
                                    @endif
                                    @if ($publikasi->komentar6)
                                    <button class="btn btn-light m-1 komentar" data-bs-toggle="modal" data-bs-target="#modalComment"
                                        onclick='showk({!! json_encode($publikasi->komentar6) !!}, "Kaprodi")'>
                                        <i class="ti ti-message me-2" id="kaprodi"></i> Kaprodi
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @if ($publikasi->status == 4)
                                <form action="{{ route('ujian.publikasi.revisi') }}" method="post" id="revisi">
                                    @csrf
                                    @method('patch')
                                    <h5 class="mt-3 mb-1"><b>Form Revisi Naskah</b></h5>
                                    <input type="hidden" name="id_pendaftaran" value="{{ $publikasi->id }}">
                                    <div class="form-group mb-3">
                                        <label for="naskah_revisi" class="form-label">Link Google Drive Naskah Baru</label>
                                        <input type="url" class="form-control naskah_revisi @error('naskah_revisi') is-invalid @enderror"
                                            name="naskah_revisi" value="{{ old('naskah_revisi') }}" placeholder="Masukkan link Google Drive naskah"
                                            required>
                                        @error('naskah_revisi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text" id="err2">Pastikan link/url Google Drive naskah dapat diakses</div>
                                    </div>
                                    <div class="form-group mb-3 text-end">
                                        <button type="submit" class="btn btn-primary btn-next naskah_revisi" id="naskah_revisi">Submit</button>
                                    </div>
                                </form>
                            @elseif ($publikasi->status == 5)
                                <div class="row mb-3">
                                    <h5 class="mb-1"><b>Link Naskah Revisi</b></h5>
                                    <div>
                                        <a href="{{ $publikasi->file ?? '' }}" target="_blank" rel="noopener noreferrer">
                                            <p class="mb-0" id="naskah">{{ $publikasi->file ?? '' }}</p>
                                        </a>
                                    </div>
                                </div>
                            @elseif ($publikasi->status == 6)
                                <div class="row mb-4">
                                    <h5 class="mb-1"><b>Link Naskah</b></h5>
                                    <div>
                                        <a href="{{ $publikasi->file ?? '' }}" target="_blank" rel="noopener noreferrer">
                                            <p class="mb-0" id="naskah">{{ $publikasi->file ?? '' }}</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group mb-3 text-center">
                                    <a href="{{ route('ujian.tertutup') }}" class="btn btn-primary btn-next">Lanjutkan <i
                                            class="ti ti-arrow-right ms-2"></i></a>
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
            $("#m_title").text("Komentar " + num);
            komentar = JSON.parse(komentar);
            showkomentars.setContents(komentar);
        };

        var progress = {{ $publikasi->status ?? 0 }};
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
            // Baris di bawah ini sengaja di-comment karena menyebabkan flicker, logika show/hide sudah cukup
            // $('[data-step]').removeClass('d-none'); 
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
        }

        @if (!$publikasi)
            $('#pendaftaran').on('submit', function(e) {
                e.preventDefault();
                progress = 1;
                init();

                // Mengisi data pada halaman konfirmasi
                var penguji = [];
                $('#dosen_search option:selected').each(function() {
                    penguji.push($(this).text().trim());
                });
                $('#penguji').text(penguji.join(', '));

                // Mengambil dan menampilkan link naskah
                var naskahUrl = $('input[name="naskah"]').val();
                $('#naskah').text(naskahUrl);
                $('#naskah_link').attr('href', naskahUrl);
            });

            $('#pendaftaran_submit').on('click', function() {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda tidak dapat mengubah data pendaftaran setelah mengajukan!",
                    icon: 'warning',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,
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

        // Inisialisasi Select2 untuk usulan penguji
        $('#dosen_search').select2({
            ajax: {
                url: $('#dosen_search').data('search-dosen-url'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('#dosen_search').data('csrf-token')
                },
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        nipNikOrNama: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(dosen) {
                            return { id: dosen.id, text: dosen.nama, nomor_induk: dosen.no_induk || 'N/A' };
                        }),
                    };
                },
                cache: true,
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error, xhr);
                }
            },
            placeholder: 'Cari dosen',
            minimumInputLength: 2,
            maximumSelectionLength: 3,
            templateResult: function(data) {
                if (data.loading) return data.text;
                return $('<span><h6 class="mb-0">' + data.text + '</h6><span class="text-muted">' + data.nomor_induk + '</span></span>');
            },
            templateSelection: function(data) {
                return data.text || data.id;
            }
        });

        $('#dosen_search').on('change', function() {
            var selectedCount = $(this).val() ? $(this).val().length : 0;
            if (selectedCount < 2) {
                $(this).siblings('.invalid-feedback').remove();
                $(this).after('<div class="invalid-feedback d-block">Anda harus memilih minimal 2 penguji</div>');
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
            }
        });
    });
</script>
@endsection